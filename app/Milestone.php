<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $table = 'milestones';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    public function objective()
    {
        return $this->belongsTo('App\Objective', 'objective_id');
    }
    public function report()
    {
        return $this->hasOne('App\Objective', 'report_id');
    }
}
