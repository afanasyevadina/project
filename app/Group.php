<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'department_id', 'lang_id', 'year_create'];

    protected $hidden = ['lang_id', 'department_id'];

    public function department()
    {
    	return $this->belongsTo('App\Department');
    }

    public function lang()
    {
    	return $this->belongsTo('App\Lang');
    }

    public function graphic()
    {
        return $this->hasOne('App\GroupGraphic')->withDefault();
    }

    public function getKursAttribute()
    {
        return date('Y') - $this->year_create + (date('n') > 8 ? 1 : 0);
    }
}
