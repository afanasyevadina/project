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

    public function permissions()
    {
        return $this->hasMany('App\TopicPermission');
    }

    public function lastMessage()
    {
    	return $this->hasOne('App\Message')->latest();
    }

    public function user()
    {
    	return $this->belongsTo('App\User')->withDefault();
    }

    public function allow()
    {
        $user = \Auth::user();
        if($user->role == 'admin') return true;;
        return $this->permissions()->where('role', $user->role)->whereIn('user_id', [0, $user->id])->exists();
    }

    public function getUnreadAttribute()
    {
        return $this->messages()->where(function($query) {
            $query->where('for_owner', \Auth::user()->id)->orWhere('for_reply', \Auth::user()->id);
        })->count();
    }
}
