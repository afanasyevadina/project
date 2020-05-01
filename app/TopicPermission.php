<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TopicPermission extends Model
{
    public $timestamps = false;
    protected $fillable = ['topic_id', 'role', 'user_id'];
}
