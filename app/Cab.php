<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cab extends Model
{
    public $timestamps = false;

    protected $fillable = ['num', 'name', 'capacity', 'description', 'corpus_id'];

    public function corpus()
    {
    	return $this->belongsTo('App\Corpus')->withDefault();
    }
}
