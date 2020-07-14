<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ExamTypePrice extends Model
{
    public function vendor(){
        return $this->belongsTo('App\Vendor', 'vendor_id');
    }

    public function examType(){
        return $this->belongsTo('App\ExamType');
    }
}
