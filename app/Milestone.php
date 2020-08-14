<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Milestone extends Model
{
    use SoftDeletes;

    protected $table = 'milestones';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    protected $dates = [
        'completed',
    ];

    public function goal()
    {
        return $this->belongsTo('App\Goal','goal_id');
    }
    public function report()
    {
        return $this->hasOne('App\Report','milestone_achieved');
    }
}
