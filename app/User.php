<?php

namespace App;

use Illuminate\Notifications\Notifiable;
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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function teams()

    {

        return $this->belongsToMany('App\Team');

    }

    public function posts()

    {

        return $this->hasMany(Post::class)->latest();

    }

    public function members()

    {


        return $this->belongsToMany(Member::class);

    }


}
