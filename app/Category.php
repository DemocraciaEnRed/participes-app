<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.
    protected $appends = ['background_color'];

    public function objectives()
    {
        return $this->hasMany('App\Objective','category_id');
    }

    public function getBackgroundColorAttribute()
    {
        return "{$this->color}33";
    }
}
