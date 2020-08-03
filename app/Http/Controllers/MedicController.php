<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\Medic;
use Validator, Auth, DB;

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
            'highest_qua' => $request['highest_qua'],
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
      $validation = Validator::make($request->all(),
      [ 
        "email" =>"required|unique:users|email",
        "password" => "required|min:6|confirmed",
        'gender' => 'required',
        'name' => 'required|min:2',      
        'highest_qua' => 'required|min:3',
        'sch_attended' => 'required',
        'experience' => 'required|min:10',
        'mobile_no' => 'required|unique:users',
      ]);

   if($validation->fails()){
      return $validation->errors();
   }
   $result = DB::transaction(function() use ($request){
      $user = UserController::save($request);
      self::store($request, $user);
   });

   return response()->json([ 
      'status' =>'success',
      'message' => 'User created successfully'

          ]);
      
    }


       /**
     * This method retrieves
     * 
     *  medic(s)
     * 
     * @param $id
     */
    public static function get($id = null){
      if(!empty($id)){
      return $data = Medic::where('id', $id)->with(['user', 'exams', 'reviews', 'offers'])->first();
    }elseif(empty($id)){
        return $data = Medic::where('id', '!=', null)->with(['user', 'exams', 'reviews', 'offers'])->paginate(20);
      }else{
        return response()->json([
          'status' => 'error',
          'message' => 'Something went wrong, data could not be retrieved'
          ]);
      }
  } 


        /**
     * This method deletes
     * 
     *  vendor
     * 
     * @param $id
     */
    public static function delete($id){
      $delete = Medic::where('id', $id)->delete();
      if($delete){
          return response()->json([ 
              'status' =>'success',
              'message' => 'User deleted successfully'
             
                                   ]);
      }else{
          return response()->json([ 
              'status' =>'error',
              'message' => 'Something went wrong user not deleted successfully'
          ]);

      }
  }

     /**
     * This method updates
     * 
     *  a user
     * 
     * @param $id
     */
    public static function update(Request $request){
      /* $validation = Validator::make($request->all(),
          [
          'vendor_name' => 'required'
          ]);
      if($validation->fails()){
          return $validation->errors();
      }*/
      $update = Medic::find($request['id']);
      if(!empty($request['sch_attended'])){
      $update->sch_attended = $request['sch_attended'];
      }
  
      if(!empty($request['highest_qua'])){
          $update->highest_qua = $request['highest_qua'];
              }
      if(!empty($request['experience'])){
          $update->experience = $request['experience'];
                  }
  
      $saved = $update->save();
  
      if($saved){
          return response()->json([ 
              'status' =>'success',
              'message' => 'user updated successfully',
              'updated' => $update
             
                                   ]);
      }else{
          return response()->json([ 
              'status' =>'error',
              'message' => 'Something went wrong user not updated successfully'
          ]);
  
      }
  
  
      }


}
