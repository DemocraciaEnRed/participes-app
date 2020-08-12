<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Community extends Model
{
    protected $table = 'communities';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = false; // if the model should be timestamped.

    public function objective()
    {
        return $this->belongsTo('App\Objective');
    }

}
