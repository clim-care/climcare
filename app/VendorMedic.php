<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorMedic extends Model
{
    public function medic(){
        return $this->belongsTo('App\Medic');
    }

    public function vendor(){
        return $this->belongsTo('App\Vendor');
    }
}
