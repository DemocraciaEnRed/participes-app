<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $table = 'action_logs';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.
}
