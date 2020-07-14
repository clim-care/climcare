<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{  
   protected $guarded = [
        
   ];

    public function exams(){
       return $this->hasMany('App\Exam');
    }

    public function setting(){
       return $this->hasOne('App\Setting');
    }

    public function examtype(){
       return $this->hasMany('ExamType');
    }

    public function examTypePrice(){
       return $this->hasMany('App\ExamTypePrice');
    }

    public function payment(){
      return $this->hasMany('App\Payment');
    }

    public function wallet(){
      return $this->hasOne('App\Wallet');
    }

    public function user(){
       return $this->belongsTo('App\User');
    }
}
