<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = 'faqs';
    public $incrementing = true; // if IDs are auto-incrementing.
    public $timestamps = true; // if the model should be timestamped.
 
   public function getSectionLabelAttribute()
    {
        switch($this->section){
            case 'general':
                return 'Acerca De';
                break;
            case 'faq':
                return 'Ayuda';
                break;
            case 'legal':
                return 'Información Legal';
                break;    
            default:
                return 'Sin etiqueta';
        }
    }

}