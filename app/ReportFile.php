<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportFile extends Model
{
    protected $table = 'report_file';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    public function file()
    {
        return $this->morphOne('App\File', 'fileable');
    }
}
