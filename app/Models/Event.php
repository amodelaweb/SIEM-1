<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    //
    function files(){
        return $this->hasMany(File::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }
}