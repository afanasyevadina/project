<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollegeGraphic extends Model
{
    public $timestamps = false;
    protected $fillable = ['year', 'start1', 'end1', 'start2', 'end2', 'weeks1', 'weeks2', 'teor1', 'teor2'];

    public function groups()
    {
    	return $this->belongsToMany('App\Group', 'group_graphics', 'graphic_id', 'group_id');
    }
}
