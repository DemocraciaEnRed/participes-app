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
    protected $appends = ['progress_percentage','status_label'];

    public function objective()
    {
        return $this->belongsTo('App\Objective');
    }
    
    public function milestones()
    {
        return $this->hasMany('App\Milestone','goal_id')->orderBy('order','ASC');
    }

    public function reports()
    {
        return $this->hasMany('App\Report','goal_id');
    }

    public function hasReport($reportId){
        return $this->reports()->where('id', $reportId)->exists();
    }

    public function getStatusLabelAttribute()
    {
        switch($this->status){
            case 'reached':
                return 'Alcanzada';
                break;
            case 'ongoing':
                return 'En progreso';
                break;
            case 'delayed':
                return 'No cumplida';
                break;
            case 'inactive':
                return 'Inactiva';
                break;

            default:
                return '???';
        }
    }
    
    public function getProgressPercentageAttribute(){
        return round( ($this->indicator_progress / $this->indicator_goal)*100 );
    }
}
