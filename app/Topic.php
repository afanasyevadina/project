<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $fillable = ['name', 'description', 'user_id'];

    protected $appends = ['time', 'date'];

    public function getTimeAttribute()
    {
        return $this->created_at->format('H:i');
    }

    public function getDateAttribute()
    {
        return $this->created_at->format('d.m.Y');
    }

    public function messages()
    {
    	return $this->hasMany('App\Message');
    }

    public function lastMessage()
    {
    	return $this->hasOne('App\Message')->latest();
    }

    public function user()
    {
    	return $this->belongsTo('App\User')->withDefault();
    }
}
