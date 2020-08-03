<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{   
    protected $guarded = [ ];

    public function vendor(){
      return  $this->belongsTo('App\Vendor', 'vendor_id');
    }

    public function medic(){
     return   $this->belongsTo('App\Medic', 'medic_id');
    }

    public function image(){
        return   $this->hasMany('App\Image');
       }

   
}
