<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use Validator, DB, Auth;
use App\Http\Controllers\UserController;

class VendorController extends Controller
{
    
    /**
    * this method stores a 
    *
    * a vendor
    *
    * @param $request, $user_id
    */

    public static function store($request, $user_id){
      return $create = Vendor::create([
        'vendor_name' => $request['vendor_name'],
        'state' => $request['state'],
        'vendor_type' => $request['vendor_type'],
        'street_address' => $request['street_address'],
        'country' => $request['country'],
        'phone' => $request['phone'],
        'description' => $request['description'],
        'user_id' => $user_id,
      ]);  
    }

    /**
    * this method creates a 
    *
    * a vendor
    *
    * @param $request
    */
    public function create(Request $request){
        $validation = Validator::make($request->all(),
        [ 
          "email" =>"required|unique:users|email",
          "password" => "required|min:6|confirmed",
          'gender' => 'required',
          'name' => 'required|min:2',      
          'vendor_name' => 'required|min:3',
          'mobile_no' => 'required',
          'description' => 'required',
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
        'message' => 'Vendor created successfully'

            ]);
   

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
    		return $data = Vendor::where('id', $id)->with(['user'])->first();
    	}elseif(empty($id)){
    		  return $data = Vendor::where('id', '!=', null)->with(['user'])->paginate(20);
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
        $delete = Vendor::where('id', $id)->delete();
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
    $update = Vendor::find($request['id']);
    if(!empty($request['vendor_name'])){
    $update->vendor_name = $request['vendor_name'];
    }
    if(!empty($request['email'])){
    $validation = Validator::make($request->all(),
        [
        'email' => 'required|unique:vendors|email'
        ]);

    if($validation->fails()){
        return $validation->errors();
    }

    $update->email = $request['email'];
        }

    if(!empty($request['state'])){
        $update->state = $request['state'];
            }
    if(!empty($request['vendor_type'])){
        $update->vendor_type = $request['vendor_type'];
                }
    if(!empty($request['street_address'])){
        $update->street_address = $request['street_address'];
                    }
    if(!empty($request['country'])){
            $update->state = $request['country'];
                        }
    if(!empty($request['phone'])){
                $update->phone = $request['phone'];
                        }

    $saved = $update->save();

    if($saved){
        return response()->json([ 
            'status' =>'success',
            'message' => 'Vendor updated successfully',
            'updated' => $update
           
                                 ]);
    }else{
        return response()->json([ 
            'status' =>'error',
            'message' => 'Something went wrong Vendor not updated successfully'
        ]);

    }


    }


}
