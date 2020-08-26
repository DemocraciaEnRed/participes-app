<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
  use SoftDeletes;

  protected $table = 'events';
  public $incrementing = true; // if IDs are auto-incrementing.
  public $timestamps = true; // if the model should be timestamped.

  protected $dates = [
    'date',
  ];

  protected $casts = [
    'urls' => 'array',
  ];

  public function author()
  {
    return $this->belongsTo('App\User', 'author_id');
  }

  public function objectives()
  {
    return $this->belongsToMany('App\Objective','event_objective','event_id','objective_id');
  }

  public function photos()
  {
      return $this->morphMany('App\ImageFile', 'imageable');
  }

  public function getMomentAttribute(){
    $dateTimeObject = $this->date->startOfDay();
    $diff = Carbon::now()->startOfDay()->diffInDays($dateTimeObject, false);
    if($diff < 0){
        return "Celebrado el {$this->date->format('d/m/Y')} a las {$this->date->format('H:i')}";
    } else if ($diff == 0){
        return "¡Hoy! El {$this->date->format('d/m/Y')} a las {$this->date->format('H:i')}" ;
    } 
    return "Próximamente el {$this->date->format('d/m/Y')} a las {$this->date->format('H:i')}";
  }
  // public function getWhenAttribute(){
  //   return "{$this->date->format('d/m/Y')} a las {$this->date->format('H:m')}";
  // }
  public function hasObjective($objectiveId){
        return $this->objectives()->where('objective_id', $objectiveId)->exists();
    }

}
