<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollegeGraphic extends Model
{
    public $timestamps = false;
    protected $fillable = ['year', 'start1', 'end1', 'start2', 'end2'];
}
