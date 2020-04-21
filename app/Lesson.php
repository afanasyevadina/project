<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'group_id', 
        'plan_id', 
        'total', 
        'order', 
        'practice', 
        'teacher_id', 
        'cab_id', 
        'date', 
        'num', 
        'part_id', 
        'topic', 
        'subgroup'
    ];

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function part()
    {
    	return $this->belongsTo('App\Part');
    }

    public function plan()
    {
    	return $this->belongsTo('App\Plan');
    }

    public function ratings()
    {
    	return $this->hasMany('App\Rating');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Teacher')->withDefault();
    }

    public function cab()
    {
        return $this->belongsTo('App\Cab')->withDefault();
    }

    public function getListAttribute()
    {
    	$list = [];
    	foreach($this->ratings as $r) {
    		$list[$r->student_id] = $r;
    	}
    	return $list;
    }
}
