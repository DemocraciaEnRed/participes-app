<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Goal extends Model
{
    use SoftDeletes;

    protected $table = 'goals';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    public function author()
    {
        return $this->belongsTo('App\User', 'author_id');
    }

    public function objective()
    {
        return $this->belongsTo('App\Objective');
    }
    public function milestones()
    {
        return $this->hasMany('App\Milestone','goal_id');
    }

    public function reports()
    {
        return $this->hasMany('App\Report','goal_id');
    }

    public function hasReport($reportId){
        return $this->reports()->where('id', $reportId)->exists();
    }

    public function statusLabel()
    {
        switch($this->status){
            case 'reached':
                return 'Alcanzada';
                break;
            case 'ongoing':
                return 'En progreso';
                break;
            case 'delayed':
                return 'Demorada';
                break;
            case 'inactive':
                return 'Inactiva';
                break;

            default:
                return '???';
        }
    }
    
    public function progressPercentage(){
        return round( ($this->indicator_progress / $this->indicator_goal)*100 );
    }
}
