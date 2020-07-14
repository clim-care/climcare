<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Vendor;
use App\Medic;
use Carbon\Carbon;
use Validator, Auth;
use Laravel\Passport\Passport;

class AuthController extends Controller
{
       /**
    * Login user and create token
    *@param [string] email
    *
    *@param [password]
    *
    *
    *@return success or failure
    *
    */
    public function login(Request $request){
        $validation = Validator::make($request->all(),
        ['email' => 'required|email',
        'password' => ' required'
        ]);
    if($validation->fails()){
        return $validation->errors();
    }

    $credentials = [
        'email' => $request['email'],
        'password' => $request['password'],
        'status' => 'active',
           ];

    if(Auth::attempt($credentials)){
        $user = Auth::user();
        $token = $user->createToken('myApp')->accessToken;
                 
        return response()->json([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => $user,
            'token' => $token,
            ]);
    }else{
        return response()->json([
            'status' => 'error',
            'message' => 'Email or Password is incorrect. Please try again']);
    }
}

}
