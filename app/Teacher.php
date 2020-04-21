<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public $timestamps = false;
    protected $fillable = ['surname', 'name', 'patronymic', 'born', 'iin', 'address', 'phone', 'email'];
    protected $appends = ['shortName', 'fullName'];

    public function getShortNameAttribute()
    {
    	return $this->surname.' '.
    	($this->name ? mb_substr($this->name, 0, 1).'.' : '').
    	($this->patronymic ? mb_substr($this->patronymic, 0, 1).'.' : '');
    }

    public function getFullNameAttribute()
    {
    	return $this->surname.' '.
    	($this->name ? ' '.$this->name : '').
    	($this->patronymic ? ' '.$this->patronymic : '');
    }
}
