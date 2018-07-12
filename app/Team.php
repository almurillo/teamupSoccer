<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{

	public function users()

	{

		return $this->belongsToMany('App\User');
		// return $this->belongsTo(User::class);

	}

	public function posts()

	{

		return $this->hasMany(Post::class)->latest();

	}



}
