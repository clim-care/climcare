<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    public function exam(){
        return   $this->belongsTo('App\Exam');
       }
}
 