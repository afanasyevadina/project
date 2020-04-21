<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['topic_id', 'user_id', 'text', 'reply_id'];

    protected $appends = ['time', 'date'];

    public function getTimeAttribute()
    {
    	return $this->created_at->format('H:i');
    }

    public function getDateAttribute()
    {
    	return $this->created_at->format('d.m.Y');
    }

    public function topic()
    {
    	return $this->belongsTo('App\Topic')->withDefault();
    }

    public function user()
    {
    	return $this->belongsTo('App\User')->withDefault();
    }

    public function reply()
    {
        return $this->belongsTo('App\Message', 'reply_id')->with('user');
    }
}
