<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'group_id', 
        'year', 
        'semestr', 
        'num', 
        'day', 
        'week', 
        'plan_id', 
        'cab_id', 
        'subgroup'
    ];

    protected $hidden = ['group_id', 'year', 'semestr'];

    public function group()
    {
    	return $this->belongsTo('App\Group');
    }

    public function plan()
    {
        return $this->belongsTo('App\Plan')->withDefault();
    }

    public function teacher()
    {
        return $this->plan->belongsTo('App\Teacher')->withDefault();
    }

    public function cab()
    {
        return $this->belongsTo('App\Cab')->withDefault();
    }
}
