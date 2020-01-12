<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $fillable = ['surname', 'name', 'patronymic', 'group_id', 'subgroup'];

    public function getShortNameAttribute()
    {
    	return $this->surname.' '.
    	mb_substr($this->name, 0, 1).'.'.
    	($this->patronymic ? mb_substr($this->patronymic, 0, 1).'.' : '');
    }

    public function group()
    {
    	return $this->belongsTo('App\Group');
    }
}
