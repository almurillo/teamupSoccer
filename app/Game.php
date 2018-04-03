<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    public function teams()

    {

    	return $this->belongsTo('App\Team')->withTimestamps();

    }
    
}
