<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Report extends Model
{
    use SoftDeletes;

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

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function goal()
    {
        return $this->belongsTo('App\Goal','goal_id');
    }

    public function milestone()
    {
        return $this->belongsTo('App\Milestone','milestone_achieved');
    }
    public function files()
    {
        return $this->morphMany('App\File','fileable');
    }

    public function photos()
    {
        return $this->morphMany('App\ImageFile','imageable');
    }

    public function testimonies()
    {
        return $this->hasMany('App\Testimony','report_id');
    }

    public function comments()
    {
        return $this->morphMany('App\Comment', 'commentable')->whereNull('parent_id');
    }
}