<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'name_kz', 'divide', 'short_name', 'short_name_kz'];
}
