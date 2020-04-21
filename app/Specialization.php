<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialization extends Model
{
    public $timestamps = false;
    protected $fillable = ['code', 'name', 'name_kz', 'department_id'];

    public function department()
    {
    	return $this->belongsTo('App\Department');
    }
}
