<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public $timestamps = false;
    protected $fillable = ['student_id', 'plan_id', 'att', 'exam', 'project', 'zachet', 'itog'];

    public function plan()
    {
    	return $this->belongsTo('App\Plan')->withDefault();
    }

    public function student()
    {
    	return $this->belongsTo('App\Student')->withDefault();
    }
}
