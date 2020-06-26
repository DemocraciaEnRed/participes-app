<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReportValidation extends Model
{
    protected $table = 'report_validation';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    public function report()
    {
        return $this->belongsTo('App\Report', 'report_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
