<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public $timestamps = false;
    protected $fillable = ['plan_id', 'date', 'time', 'cab_id', 'kons_date', 'kons_time', 'kons_cab_id'];

    public function cab()
    {
    	return $this->belongsTo('App\Cab')->withDefault();
    }

    public function konsCab()
    {
    	return $this->belongsTo('App\Cab', 'kons_cab_id')->withDefault();
    }
}
