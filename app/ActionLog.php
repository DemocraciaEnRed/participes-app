<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActionLog extends Model
{
    protected $table = 'action_logs';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = false; // if the model should be timestamped.

    // protected $casts = [
    //     'meta' => 'array',
    // ];

    protected $fillable = ['message','context','level','level_name','channel','record_datetime','extra','formatted','remote_addr','user_agent','created_at'];
}
