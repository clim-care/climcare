<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    public function vendor(){
        $this->belongsTo('App\Vendor', 'vendor_id');
    }

    public function medic(){
        $this->belongsTo('App\Medic', 'medic_id');
    }
}
