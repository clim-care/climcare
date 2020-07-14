<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\Medic;

class MedicController extends Controller
{
    /**
     * this method saves 
     * 
     * the medics detial
     * 
     * @param [$request, $user_id]
     * 
     */

     public static function store($request, $user_id){
          return Medic::create([
            'sch_attended' => $request['sch_attended'],
            'highest_qualification' => $request['highest_qualification'],
            'experience' => $request['experience'],
            'user_id' => $user_id
          ]);
     }

      /**
     * this method creates 
     * 
     * a medic 
     * 
     * @param [$request, $user_id]
     * 
     */
    public function create(Request $request){

    }
}
