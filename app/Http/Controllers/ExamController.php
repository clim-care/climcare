<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exam;
use App\ExamType;
use Carbon\Carbon;
use DB, Auth, Validator;

class ExamController extends Controller
{
    /**
    * saves examtype details
    *
    * @param $request
    *
    * @return id
     */
    public static function save(Request $request){
        $create = Exam::create([
            'vendor_id' => $request['vendor_id'],
            'medic_id' => $request['medic_id'],
            'exam_type_id' => $request['exam_type_id'],
            'date_posted' => Carbon::now(),
            'status' => $request['status'],
            'examinar_comment' => $request['examinar_comment'],
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
         'vendor_id' => 'required',
         'medic_id' => 'required',
         'exam_type_id' => 'required',
        ]);
        
    if($validation->fails()){
        return $validation->errors();
    }
   // return $request->all();
        $result = self::save($request);
        if($result){
            return response()->json([ 
                'status' =>'success',
                'message' => 'Exam posted successfully'

                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Exam not posted successfully'
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
    		return $data = Exam::where('id', $id)->with(['vendor', 'medic', 'image'])->first();
    	}elseif(empty($id)){
    		  return $data = Exam::where('id', '!=', null)->with(['vendor', 'medic', 'image'])->paginate(20);
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
        $delete = Exam::where('id', $id)->delete();
        if($delete){
            return response()->json([ 
                'status' =>'success',
                'message' => 'Exam deleted successfully'
               
                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Something went wrong exam not deleted successfully'
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
      
    $update = Exam::find($request['id']);

    if(!empty($request['exam_comment'])){
    $update->examinar_comment = $request['examinar_comment'];
    }

    $saved = $update->save();

    if($saved){
        return response()->json([ 
            'status' =>'success',
            'message' => 'Exam updated successfully',
            'updated' =>$update
                                 ]);
    }else{
        return response()->json([ 
            'status' =>'error',
            'message' => 'Something went wrong exam not updated successfully'
        ]);

    }


    }

      /**
     * This method examines
     * 
     *  exam type
     * 
     * @param $id
     */
    public static function examined(Request $request){
           
       $examined = Exam::find($request['id']);
       if(!empty($request['examinar_comment'])){
        $examined->examinar_comment = $request['examinar_comment'];
        $examined->status = $request['status'];
        }
      $result = $examined->save();
      if($result){
        return response()->json([ 
            'status' =>'success',
            'message' => 'Exam updated successfully',
            'updated' =>$examined
                                 ]);
    }else{
        return response()->json([ 
            'status' =>'error',
            'message' => 'Something went wrong exam not updated successfully'
        ]);

    }
    }

}
