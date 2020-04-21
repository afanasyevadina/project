<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cab extends Model
{
    public $timestamps = false;

    protected $fillable = ['num', 'name', 'capacity', 'description'];
}
