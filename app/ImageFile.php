<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageFile extends Model
{
    protected $table = 'image_files';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.

    protected $hidden = [
        'imageable_type', 'imageable_id', 
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
