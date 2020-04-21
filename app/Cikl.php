<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cikl extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'name_kz', 'short_name', 'short_name_kz'];
}
