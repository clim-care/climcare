<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use DB, Auth;
class SettingController extends Controller
{
     /**
    * saves examtype details
    *
    * @param $request
    *
    * @return id
     */
    public static function save(Request $request){
        $create = Setting::create([
            'currency' => $request['currency'],
            'lang' => $request['lang'],
            'vat' => $request['vat'],
            'vendor_id' => $request['vendor_id'],
           
        ]);
        
        return $create->id;

    }
    /**
     * This method creates 
     * 
     * exam type
     * 
     * @param $request
     * 
     * @return response
     */
    public function create(Request $request){
        $validation = Validator::make($request->all(),
        [
         'currency' => 'required',
        ]);
        
    if($validation->fails()){
        return $validation->errors();
    }
   // return $request->all();
        $result = self::save($request);
        if($result){
            return response()->json([ 
                'status' =>'success',
                'message' => 'Setting created successfully'

                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Setting not created successfully'
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
    		return $data = Setting::where('id', $id)->with(['vendor'])->first();
    	}elseif(empty($id)){
    		  return $data = Setting::where('id', '!=', null)->with(['vendor'])->paginate(20);
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
     *  exam type
     * 
     * @param $id
     */
    public static function delete($id){
        $delete = Setting::where('id', $id)->delete();
        if($delete){
            return response()->json([ 
                'status' =>'success',
                'message' => 'Setting deleted successfully'
               
                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Something went wrong setting not deleted successfully'
            ]);

        }
    }

    /**
     * This method updates
     * 
     *  exam type
     * 
     * @param $id
     */
    public static function update(Request $request){
      
    $update = Setting::find($request['id']);

    if(!empty($request['currency'])){
    $update->currency = $request['currency'];
    }

    if(!empty($request['lang'])){
        $update->lang = $request['lang'];
        }

    if(!empty($request['vat'])){
            $update->vat = $request['vat'];
            }

    $saved = $update->save();

    if($saved){
        return response()->json([ 
            'status' =>'success',
            'message' => 'Setting updated successfully',
            'updated' =>$update
                                 ]);
    }else{
        return response()->json([ 
            'status' =>'error',
            'message' => 'Something went wrong setting not updated successfully'
        ]);

    }


    }


}
