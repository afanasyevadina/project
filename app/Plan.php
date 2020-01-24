<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    public $timestamps = false;

    protected $fillable = ['group_id', 'semestr', 'cikl_id', 'subject_id', 'theory', 'practice', 'lab', 'project', 'is_exam', 'is_project', 'is_zachet', 'controls', 'theory_main', 'practice_main', 'total', 'weeks', 'subgroup', 'shifr', 'shifr_kz'];

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
}
