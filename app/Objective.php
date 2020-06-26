<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Objective extends Model
{
    protected $table = 'objectives';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.


    public function category()
    {
        return $this->hasOne('App\Objective', 'category_id');
    }

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function organizations()
    {
        return $this->belongsToMany('App\Organization','objective_organization','objective_id','organization_id');
    }

    public function milestones()
    {
        return $this->hasMany('App\Milestone','objective_id');
    }

    public function goals()
    {
        return $this->hasMany('App\Goal','objective_id');
    }

    public function files()
    {
        return $this->hasMany('App\ObjectiveFile','objective_id');
    }

    public function pictures()
    {
        return $this->hasMany('App\ObjectivePicture','objective_id');
    }

    public function events()
    {
        return $this->belongsToMany('App\Event','event_objective','objective_id','event_id');
    }
}