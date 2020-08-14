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
        'map_center' => 'array',
        'map_geometries' => 'array'
    ];

    public function objective()
    {
        return $this->goal->objective();
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

    public function positiveTestimonies()
    {
        return $this->testimonies()->where('value', true);
    }

    public function negativeTestimonies()
    {
        return $this->testimonies()->where('value', false);
    }

    public function userTestimony($userId)
    {
        return $this->testimonies()->where('user_id', $userId);
    }
    public function typeLabel()
    {
        switch($this->type){
            case 'post':
                return 'Novedad';
                break;
            case 'progress':
                return 'Avance';
                break;
            case 'milestone':
                return 'Hito';
                break;    
            default:
                return 'Sin etiqueta';
        }
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
    public function typeIcon()
    {
        switch($this->type){
            case 'post':
                return 'fas fa-bullhorn';
                break;
            case 'progress':
                return 'fas fa-fast-forward';
                break;
            case 'milestone':
                return 'fas fa-medal';
                break;
            default:
                return 'fas fa-question';
                break;
        }
    }
}