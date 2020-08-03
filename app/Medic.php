<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medic extends Model
{  protected $guarded = [
        
];
    public function exams(){
       return $this->hasMany('App\Exam');
    }

    public function payment(){
      return  $this->hasMany('App\Payment');
    }

    public function reviews(){
        return $this->hasMany('App\ReviewMedic');
    }

    public function user(){
      return $this->belongsTo('App\User');
  }

  public function offers(){
    return $this->hasMany('App\SendRequest');
}

public function medicContracts(){
  return $this->hasMany('App\VendorMedic', 'medic_id');
}

}
