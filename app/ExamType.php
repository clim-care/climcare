<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{   
    protected $guarded = [ ];

    public function vendor(){
        return $this->belongsTo('App\Vendor');
    }

    public function prices(){
        return $this->hasMany('App\ExamTypePrice');
    }
}
