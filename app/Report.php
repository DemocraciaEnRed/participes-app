<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    protected $dates = [
        'date',
    ];

    protected $casts = [
        'tags' => 'array',
    ];

    public function objective()
    {
        return $this->hasOneThrough(
            'App\Objective',
            'App\Goal',
            'objective_id', // Foreign key on cars table...
            'goal_id', // Foreign key on owners table...
            'id', // Local key on mechanics table...
            'id' // Local key on cars table...
        );
    }
    public function goal()
    {
        return $this->belongsTo('App\Goal','goal_id');
    }

    public function milestone_achieved()
    {
        return $this->hasOne('App\Milestone','milestone_achieved');
    }
    public function files()
    {
        return $this->hasMany('App\ReportFile','report_id');
    }

    public function pictures()
    {
        return $this->hasMany('App\ReportPicture','report_id');
    }

    public function testimonies()
    {
        return $this->hasMany('App\Testimony','report_id');
    }
}