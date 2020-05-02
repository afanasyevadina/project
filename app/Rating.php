<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    public $timestamps = false;
    protected $fillable = ['lesson_id', 'value', 'student_id', 'miss'];

    public function lesson()
    {
    	return $this->belongsTo('App\Lesson');
    }
}
