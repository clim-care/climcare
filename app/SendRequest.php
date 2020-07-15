<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendRequest extends Model
{
    protected $guarded = [
        
    ];

    public function medic(){
        $this->belongsTo('App\Medic', 'medic_id');
    }

    public function vendor(){
        $this->belongsTo('App\Vendor', 'vendor_id');
    }
}
