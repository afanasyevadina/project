<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Lesson;
use App\Rating;
use App\Result;

class Plan extends Model
{
    public static function boot()
    {
        parent::boot();

        static::created(function ($plan) {
            $plan->generateLessons();
        });

        static::updated(function ($plan) {
            $plan->generateLessons();
        });
    }
    public $timestamps = false;

    protected $fillable = ['group_id', 'semestr', 'cikl_id', 'subject_id', 'theory', 'practice', 'lab', 'project', 'is_exam', 'is_project', 'is_zachet', 'controls', 'total', 'weeks', 'subgroup', 'shifr', 'shifr_kz', 'year', 'teacher_id', 'exam', 'consul'];

    public function subject()
    {
    	return $this->belongsTo('App\Subject');
    }

    public function cikl()
    {
    	return $this->belongsTo('App\Cikl');
    }

    public function teacher()
    {
    	return $this->belongsTo('App\Teacher')->withDefault();
    }

    public function group()
    {
        return $this->belongsTo('App\Group')->withDefault();
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson')->with('part')->orderBy('order', 'asc');
    }

    public function graphicExam()
    {
        return $this->hasOne('App\Exam')->withDefault();
    }

    public function getKursAttribute()
    {
        return $this->year - $this->group->year_create + 1;
    }

    public function getProjectMainAttribute()
    {
        return static::where('group_id', $this->group_id)
        ->where('cikl_id', $this->cikl_id)
        ->where('subject_id', $this->subject_id)
        ->where('subgroup', '<>', 2)
        ->sum('project');
    }

    public function getPracticeMainAttribute()
    {
        return static::where('group_id', $this->group_id)
        ->where('cikl_id', $this->cikl_id)
        ->where('subject_id', $this->subject_id)
        ->where('subgroup', '<>', 2)
        ->sum('practice') + static::where('group_id', $this->group_id)
        ->where('subject_id', $this->subject_id)
        ->where('subgroup', '<>', 2)
        ->sum('lab');
    }

    public function getTheoryMainAttribute()
    {
        return static::where('group_id', $this->group_id)
        ->where('cikl_id', $this->cikl_id)
        ->where('subject_id', $this->subject_id)
        ->where('subgroup', '<>', 2)
        ->sum('theory');
    }

    public function getTotalMainAttribute()
    {
        return static::where('group_id', $this->group_id)
        ->where('cikl_id', $this->cikl_id)
        ->where('subject_id', $this->subject_id)
        ->where('subgroup', '<>', 2)
        ->sum('total');
    }

    public function getMainAttribute()
    {
        return static::where('group_id', $this->group_id)
        ->where('cikl_id', $this->cikl_id)
        ->where('subject_id', $this->subject_id)
        ->where('year', $this->year)
        ->where('semestr', $this->semestr)
        ->where('subgroup', '<>', 2)
        ->first();
    }

    public function generateLessons()
    {
        $left = $this->total;
        $order = 0;
        foreach($this->lessons as $lesson) {
            if(!$left) {
                $lesson->delete();
                continue;
            }
            if($this->subject->divide == 1 || $this->subgroup == 2) {
                $lesson->subgroup = $this->subgroup;
            }
            $lesson->group_id = $this->group_id;
            $lesson->save();
            $left -= $lesson->total;
            $order ++;
        }
        while ($left > 0) {
            $given = $left < 2 ? 1 : 2;
            $lesson = Lesson::create([
                'plan_id' => $this->id,
                'group_id' => $this->group_id,
                'total' => $given,
                'order' => ++$order,
            ]);
            if($this->subject->divide == 1 || $this->subgroup == 2) {
                $lesson->subgroup = $this->subgroup;
            }
            $lesson->group_id = $this->group_id;
            $lesson->save();
            $left -= $given;
        }
        return true;
    }

    public function generateRatings()
    {
        foreach($this->group->students as $s) {
            foreach($this->lessons as $l) {
                if(!$l->subgroup || $l->subgroup == $s->subgroup) {
                    $rating = Rating::updateOrCreate([
                        'student_id' => $s->id,
                        'lesson_id' => $l->id,
                    ]);
                    $rating->save();
                } else {
                    Rating::where([
                        'student_id' => $s->id,
                        'lesson_id' => $l->id,
                    ])->delete();
                }
            }
        }
    }

    public function checkNext($date)
    {
        if($this->subgroup == 2 && $this->subject->divide == 2 && !empty($this->main)) {
            $nextMain = $this->main->lessons()
            ->whereNull('date')->orWhere('date', $date)->orderBy('order', 'asc')->first();
            $next = $this->lessons()->whereNull('date')->orWhere('date', $date)->orderBy('order', 'asc')->first();
            return $next && $nextMain && $nextMain->practice > 0;
        }
        return true;
    }
}
