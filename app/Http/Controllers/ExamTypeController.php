<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExamType;
use App\Vendor;
use DB, Auth, Validator;

class ExamTypeController extends Controller
{
    /**
    * saves examtype details
    *
    * @param $request
    *
    * @return id
     */
    public static function save(Request $request){
        $create = ExamType::create([
            'name' => $request['name'],
            'amount' => $request['amount'],
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
         'name' => 'required',
        ]);
        
    if($validation->fails()){
        return $validation->errors();
    }
   // return $request->all();
        $result = self::save($request);
        if($result){
            return response()->json([ 
                'status' =>'success',
                'message' => 'Exam type created successfully'

                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Exam type not created successfully'
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
    		return $data = ExamType::where('id', $id)->with(['vendor'])->first();
    	}elseif(empty($id)){
    		  return $data = ExamType::where('id', '!=', null)->with(['vendor'])->paginate(20);
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
        $delete = ExamType::where('id', $id)->delete();
        if($delete){
            return response()->json([ 
                'status' =>'success',
                'message' => 'Exam type deleted successfully'
               
                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Something went wrong exam type not deleted successfully'
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
      
    $update = ExamType::find($request['id']);

    if(!empty($request['name'])){
    $update->name = $request['name'];
    }

    if(!empty($request['amount'])){
        $update->amount = $request['amount'];
        }

    $saved = $update->save();

    if($saved){
        return response()->json([ 
            'status' =>'success',
            'message' => 'Exam type updated successfully',
            'updated' =>$update
                                 ]);
    }else{
        return response()->json([ 
            'status' =>'error',
            'message' => 'Something went wrong exam type not updated successfully'
        ]);

    }


    }

 

}
