<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\VendorMedic;
use Carbon\Carbon;
use DB, Auth, Validator;

class VendorMedicController extends Controller
{
     
    /**
    * this method stores a 
    *
    * a vendorMedic
    *
    * @param $request, $user_id
    */

    public static function store($request){
        return $create = VendorMedic::create([
          'vendor_id' => $request['vendor_id'],
          'medic_id' => $request['medic_id'],
          'status' => $request['status'],
        ]);  
      }
  
      /**
      * this method creates a 
      *
      * a vendorMedic
      *
      * @param $request
      */
      public function create(Request $request){
          $validation = Validator::make($request->all(),
          [ 
            "vendor_id" =>"required",
            "medic_id" => "required",
            'status' => 'required',
          ]);
  
       if($validation->fails()){
          return $validation->errors();
       }
       try{
       DB::transaction(function() use ($request){
         // $user = UserController::save($request);
          self::store($request);
       });
  
       return response()->json([ 
          'status' =>'success',
          'message' => 'Vendor medic created successfully'
  
              ]);
       }catch(Exception $e){
        return response()->json([ 
            'status' =>'error',
            'message' => 'Something went wrong vendor medic not created successfully'
    
                ]);
       }
  
      }
  
    
       /**
       * This method retrieves
       * 
       *  vendor(s)
       * 
       * @param $id
       */
      public static function get($id = null){
          if(!empty($id)){
              return $data = VendorMedic::where('id', $id)->with(['user'])->first();
          }elseif(empty($id)){
                return $data = VendorMedic::where('id', '!=', null)->with(['user'])->paginate(20);
              }else{
            return response()->json([
              'status' => 'error',
              'message' => 'Something went wrong, data could not be retrieved'
              ]);
          }
      }  

        /**
       * This method retrieves
       * 
       *  vendor Contracts
       * 
       * @param $vendor_id
       */
      public static function vendorContracts($vendor_id){
     return VendorMedic::where('vendor_id', $vendor_id)->with(['medic', 'vendor'])->get();
    } 


     /**
       * This method retrieves
       * 
       *  medic Contracts
       * 
       * @param $medic_id
       */
      public static function medicContracts($medic_id){
        return VendorMedic::where('medic_id', $medic_id)->with(['medic', 'vendor'])->get();
    } 

       /**
       * This method terminates
       * 
       *  vendor medic engagement/contract
       * 
       * @param $id
       */
      public static function terminateContract($id){
        
            $data = VendorMedic::where('id', $id)->with(['medic', 'vendor'])->first();
            $data->status = 'terminated';
            $data->date_ended = Carbon::now();
            $result = $data->save();
            if($result){
            return response()->json([
                'status' => 'success',
                'message' => 'This contract has been terminated',
                'data' => $data,
                ]);
       
            }else{
          return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong, contract could not be terminated',
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
          $delete = VendorMedic::where('id', $id)->delete();
          if($delete){
              return response()->json([ 
                  'status' =>'success',
                  'message' => 'Vendor deleted successfully'
                 
                                       ]);
          }else{
              return response()->json([ 
                  'status' =>'error',
                  'message' => 'Something went wrong Vendor not deleted successfully'
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
      $update = VendorMedic::find($request['id']);
      if(!empty($request['status'])){
      $update->status = $request['status'];
      }
     
      $saved = $update->save();
  
      if($saved){
          return response()->json([ 
              'status' =>'success',
              'message' => 'Vendor-medic updated successfully',
              'updated' => $update
             
                                   ]);
      }else{
          return response()->json([ 
              'status' =>'error',
              'message' => 'Something went wrong Vendor-medic not updated successfully'
          ]);
  
      }
  
  
      }
  
}
