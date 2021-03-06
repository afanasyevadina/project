<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['username'];

    public function person()
    {
        if($this->role == 'teacher') return $this->belongsTo('App\Teacher', 'person_id')->withDefault();
        if($this->role == 'student') return $this->belongsTo('App\Student', 'person_id')->withDefault();
    }

    public function getUserNameAttribute()
    {
        if($this->role == 'teacher') return $this->person->fullName;
        if($this->role == 'student') return $this->person->name.' '.$this->person->surname;
        return $this->name;
    }
}
