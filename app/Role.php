<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    public function users()
    {
        // return $this->belongsToMany('App\User','roles_user','role_id','user_id')->withTimestamps();
        return $this->belongsToMany('App\User')->withTimestamps();
    }
}
