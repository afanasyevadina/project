<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Change extends Model
{
    public $timestamps = false;

    protected $fillable = ['day', 'group_id', 'subject', 'num'];

    public function group()
    {
    	return $this->belongsTo('App\Group');
    }
}
