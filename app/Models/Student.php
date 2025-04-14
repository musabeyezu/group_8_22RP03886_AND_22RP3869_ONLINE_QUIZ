<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Student extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'fullname',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function attempts()
    {
        return $this->hasMany(Attempt::class);
    }

    public function results()
    {
        return $this->hasManyThrough(Result::class, Attempt::class);
    }
}
