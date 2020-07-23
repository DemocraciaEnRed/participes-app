<?php

namespace App;

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
    return $this->belongsToMany('App\User','autor_id');
  }

  public function objectives()
  {
    return $this->belongsToMany('App\Objective','event_objective','event_id','objective_id');
  }

  public function pictures()
  {
      return $this->morphMany('App\File', 'fileable');
  }
}
