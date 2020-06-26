<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ObjectiveFile extends Model
{
    protected $table = 'objective_file';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    public function file()
    {
        return $this->morphOne('App\File', 'fileable');
    }
}
