<?php

namespace App;

use App\DateConvert;
use App\Plan;
use App\Result;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $fillable = ['surname', 'name', 'patronymic', 'group_id', 'subgroup', 'iin', 'born', 'enter', 'pay_id', 'address', 'phone', 'email', 'photo'];

    public function getShortNameAttribute()
    {
    	return $this->surname.' '.
    	mb_substr($this->name, 0, 1).'.'.
    	($this->patronymic ? mb_substr($this->patronymic, 0, 1).'.' : '');
    }

    public function getFullNameAttribute()
    {
        return $this->surname.' '.
        ($this->name ? ' '.$this->name : '').
        ($this->patronymic ? ' '.$this->patronymic : '');
    }

    public function group()
    {
        return $this->belongsTo('App\Group')->withDefault();
    }

    public function ratings()
    {
        return $this->hasMany('App\Rating');
    }

    public function avgRating($subject, $semestr)
    {
        $avg = $this->ratings()->whereHas('lesson', function($q1) use($subject, $semestr) {
            $q1->whereHas('plan', function($q2) use($subject, $semestr) {
                $q2->where('subject_id', $subject)->where('semestr', $semestr);
            });
        })->avg('value');
        return $avg ? round($avg, 2) : '';
    }

    public function results() 
    {
        return $this->hasMany('App\Result');
    }

    public function subjects($semestr)
    {
        $subjects = Plan::select('subject_id', 'semestr')
        ->where('group_id', $this->group_id)
        ->where('semestr', $semestr)
        ->whereNotIn('cikl_id', [7,8,9])
        ->distinct()->get();
        return $subjects;
    }
}
