<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SendRequest;
 use App\Medic;
 use App\Vendor;
use Carbon\Carbon;
use App\Http\Controllers\VendorMedicController;
use DB, Auth, Validator;

class SendRequestController extends Controller
{
    /**
     * saves the request
     * 
     * data into db
     * 
     * @param $request
     */
    public static function store(Request $request){
       return SendRequest::create([
            'vendor_id' => $request['vendor_id'],
            'medic_id' => $request['medic_id'],
            'status' => 'pending',
            'description' => $request['description'],
        ]);

    }

     /**
     * creates an offer
     * 
     * to the medi
     * 
     * @param $request
     */
    public function create(Request $request){
        $result = self::store($request);
        if($result){
            return response()->json([
                'status' => 'success',
                'message' => ' Request sent successfully',
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => ' Request not sent successfully',
            ]);
        }
    }

     
     /**
     * This method retrieves
     * 
     *  request(s)
     * 
     * @param $id
     */
    public static function get($id = null, $status = null){
        if(!empty($id) && empty($status)){
    		return $data = SendRequest::where('id', $id)->with(['vendor', 'medic'])->first();
    	}elseif(empty($id) && empty($status)){
    		  return $data = SendRequest::where('id', '!=', null)->with(['vendor', 'medic'])->paginate(20);
            }elseif(empty($id) && !empty($status)){
                return $data = SendRequest::where('status', $status)->with(['medic', 'vendor'])->get();
            }else{
          return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong, data could not be retrieved'
            ]);
        }
    }  


     /**
     * The medic response to
     * 
     * a request to whether
     * 
     * to accept an offer or decline
     * 
     */
    public static function acceptOffer($id){
        try{
        DB::transaction(function() use ($id){
       $requestResponse = SendRequest::where('id', $id)->with(['vendor', 'medic'])->first();
       $requestResponse->status = 'accepted';
       $requestResponse->date_responded = Carbon::now();
       $result = $requestResponse->save();
       $data = [
           'vendor_id' => $requestResponse->vendor_id,
           'medic_id' => $requestResponse->medic_id,
           'status' => 'active',
       ];
       VendorMedicController::store($data);
          });
        return response()->json([
            'status' => 'success',
            'message' => 'Offer accepted',
            'data' => $requestResponse,
        ]);
       }catch(Exception $e){
        return response()->json([
            'status' => 'error',
            'message' => 'Something went wrong request could not be processed',
        ]);
       }
    }


    /**
     * Declines medic requset/offer 
     * 
     * a request to whether
     * 
     * to accept an offer or decline
     * 
     */
    public static function declineOffer($id){
        $requestResponse = SendRequest::where('id', $id)->with(['vendor', 'medic'])->first();
        $requestResponse->status = 'declined';
        $requestResponse->date_responded = Carbon::now();
        $result = $requestResponse->save();
        if($result){
         return response()->json([
             'status' => 'success',
             'message' => 'Offer declined',
             'data' => $requestResponse,
         ]);
        }else{
         return response()->json([
             'status' => 'error',
             'message' => 'Something went wrong request could not be processed',
         ]);
        }
     }

     /**
     * deletes a 
     * 
     * @var $id
     * 
     * @public 
     */
    public static function delete($id){
        $delete = SendRequest::where('id', $id)->delete();
        if($delete){
            return response()->json([ 
                'status' =>'success',
                'message' => 'Offer deleted successfully'
               
                    ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Something went wrong offer not deleted successfully'
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
      
        $update = SendRequest::find($request['id']);
    
        if(!empty($request['description'])){
        $update->description = $request['description'];
        }
        
        $saved = $update->save();
    
        if($saved){
            return response()->json([ 
                'status' =>'success',
                'message' => 'Offer updated successfully',
                'updated' =>$update
                                     ]);
        }else{
            return response()->json([ 
                'status' =>'error',
                'message' => 'Something went wrong offer not updated successfully'
            ]);
    
        }
    
    
        }

/**
 * get pending request
 * 
 * by a medic
 * @param $medic_id
 */
public static function getPendingOfferBYMedic($medic_id){
    return SendRequest::where('medic_id', $medic_id)->where('status', 'pending')->with(['vendor'])->get();
}
    
}
