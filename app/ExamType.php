<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamType extends Model
{
    public function vendor(){
        return $this->belongsTo('App\Vendor', 'vendor_id');
    }

    public function prices(){
        return $this->hasMany('App\ExamTypePrice');
    }
}
