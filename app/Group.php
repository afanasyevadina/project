<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'specialization_id', 'lang_id', 'year_create', 'year_leave', 'teacher_id', 'kurs', 'base'];

    protected $hidden = ['lang_id', 'specialization_id'];

    protected $appends = ['codes'];

    public function specialization()
    {
    	return $this->belongsTo('App\Specialization');
    }

    public function lang()
    {
    	return $this->belongsTo('App\Lang');
    }

    public function students()
    {
        return $this->hasMany('App\Student')->orderBy('surname', 'asc')
        ->orderBy('name', 'asc');
    }

    public function graphics()
    {
        return $this->belongsToMany('App\CollegeGraphic', 'group_graphics', 'group_id', 'graphic_id');
    }

    public function teacher()
    {
        return $this->belongsTo('App\Teacher')->withDefault();
    }

    public function getCodesAttribute()
    {
        $codes = [];
        $name = $this->name;
        for($kurs = 1; $kurs <= 4; $kurs++) {
            if($this->base == 11) $kurs++;
            for($key = 0; $key < mb_strlen($name); $key++) {
                if(is_numeric($name[$key])) {
                    $name[$key] = $kurs;
                    break;
                }
            }
            $codes[$kurs] = $name;
        }
        return $codes;
    }
}
