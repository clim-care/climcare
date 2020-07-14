<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ReviewMedic extends Model
{
    public function medic(){
        return $this->belongsTo('App\Medic');
    }
}
