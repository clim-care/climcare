<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator, Auth;

class UserController extends Controller
{   /**
    * saves user details
    *
    *
     */
    public static function save(Request $request){
        $create = User::create([
            'gender' => $request['gender'],
            'mobile_no' => $request['mobile_no'],
            'name' => $request['name'],
            'email' => $request['email'],
            'status' => 'active',
            'password' => bcrypt($request['password']),
            'user_level' => $request['user_level']
        ]);
        
        return $create->id;

    }
    /**
     * This method creates 
     * 
     * a user
     * 
     * @param $request
     */
    public function create(Request $request){
        $validation = Validator::make($request->all(),
        [
        'name' => 'required',
        "password" => "required|min:6|confirmed",
    	"email" =>"required|unique:users|email",
    	"gender" => "required",
    	"mobile_no" => "required|unique:users|numeric",
        ]);
        
    if($validation->fails()){
        return $validation->errors();
    }
   // return $request->all();
        $result = self::save($request);
        if($result){
            return response()->json([ 
                'status' =>'success',
                'message' => 'User created successfully'

                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'User not created successfully'
            ]);

        }

    }

     /**
     * This method retrieves
     * 
     *  user(s)
     * 
     * @param $id
     */
    public static function get($id = null){
        if(!empty($id)){
    		return $data = User::where('id', $id)->first();
    	}elseif(empty($id)){
    		  return $data = User::where('id', '!=', null)->paginate(20);
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
     *  user
     * 
     * @param $id
     */
    public static function delete($id){
        $delete = User::where('id', $id)->delete();
        if($delete){
            return response()->json([ 
                'status' =>'success',
                'message' => 'User deleted successfully'
               
                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Something went wrong User not deleted successfully'
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
        ['email' => 'required|email',
        'name' => 'required'
        ]);
    if($validation->fails()){
        return $validation->errors();
    }*/
    $update = User::find($request['id']);

    if(!empty($request['name'])){
    $update->name = $request['name'];
    }

    if(!empty($request['email'])){

        $validation = Validator::make($request->all(),
        ['email' => 'required|email|unique:users',
        ]);
        if($validation->fails()){
            return $validation->errors();
        }
    $update->email = $request['email'];
    }

    if(!empty($request['gender'])){
        $update->gender = $request['gender'];
        }

    if(!empty($request['mobile_no'])){
            $update->mobile_no = $request['mobile_no'];
                }

    $saved = $update->save();

    if($saved){
        return response()->json([ 
            'status' =>'success',
            'message' => 'User updated successfully',
            'updated' =>$update
                                 ]);
    }else{
        return response()->json([ 
            'status' =>'error',
            'message' => 'Something went wrong User not updated successfully'
        ]);

    }


    }

    /**
* This method updates the password
*
* for the users
*
*/
public static function changePassword(Request $request){
    $data = $request->all();

  $validation = Validator::make($request->all(),
    ["user_id" => "required",
    "old_password" =>"required|string",
    "new_password" => "required|min:6",
    ]);
  if($validation->fails()){
    return $validation->errors();
  }

    $confirm = User::where('id', $data['user_id'])->first();
    if(password_verify($data['old_password'], $confirm->password)){
      $update = User::find($data['user_id']);
      $update->password = bcrypt($data['new_password']);
      $update->save();
       return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully']);
    }else{
      return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong, password not updated successfully. Please try again'
            ]);
    }
}
/**
* Uploading image
*
*
*/

public function uploadImg(Request $request){
 if(!empty($request['avatar'])){
        $user = User::find(Auth::user()->id);
          $user->avatar = ImageController::avatar($request);
          $user->save();
        }
}
}
