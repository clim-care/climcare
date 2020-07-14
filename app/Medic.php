<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Medic extends Model
{
    public function exams(){
       return $this->hasMany('App\Exam');
    }

    public function payment(){
      return  $this->hasMany('App\Payment');
    }

    public function reviews(){
        return $this->hasMany('App\ReviewMedic');
    }
}
