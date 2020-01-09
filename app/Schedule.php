<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $timestamps = false;

    protected $fillable = ['group_id', 'year', 'semestr', 'num', 'day', 'subject', 'teacher'];

    protected $hidden = ['group_id', 'year', 'semestr', 'num', 'day'];

    public function group()
    {
    	return $this->belongsTo('App\Group');
    }
}
