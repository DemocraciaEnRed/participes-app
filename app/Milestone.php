<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $table = 'milestones';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    public function goal()
    {
        return $this->belongsTo('App\Goal');
    }
    public function report()
    {
        return $this->belongsTo('App\Report');
    }
}
