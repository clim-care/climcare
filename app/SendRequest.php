<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SendRequest extends Model
{
    protected $guarded = [
        
    ];

    // 
    public function medic(){
      return  $this->belongsTo('App\Medic');
    }

    //
    public function vendor(){
      return  $this->belongsTo('App\Vendor');
    }
}
