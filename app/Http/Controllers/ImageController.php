<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Image;
use DB, File, Image;

class ImageController extends Controller
{
    
     /**
     * @access public
     *
     * @static
     * 
     * @var $requuest
     * 
     * @return bool
     */
    public static function avatar(Request $request)
    {
        if ($request->hasFile('avatar'))
        {    
            $file = $request->file('avatar');
            $filename = rand().'-'.$file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
            $path = public_path('images/avatar/'.$filename);
            $avatar = Image::make($file->getRealPath())->resize(50, 60)->save($path);
             return $filename;
          /*  $image = new Image;
            $image->name = $filename;
            $image->imegeable_id = $request['user_id'];
            $image->imageable_type = 'App\User';
            $image->save(); */
        }
        else{
            return false;
        }

    }

     /**
     * @access public
     *
     * @static
     * 
     * @var $requuest
     * 
     * @return bool
     */
    public static function productType(Request $request, $id = null)
    {
        if ($request->hasFile('image'))
        {    foreach ($request->file('image') as $image) {
        
            $file = $image;
            $filename = rand().'-'.$file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
            $path = public_path('images/productType/'.$filename);
            $avatar = Image::make($file->getRealPath())->resize(120, 100)->save($path);
            // return $filename;
            $image = new Image;
            $image->name = $filename;
            $image->imegeable_id = $id;
            $image->imageable_type = 'App\ProductType';
            $image->save();
            }
        }
        else{
            return false;
        }

    }

    /**
     * @access public
     *
     * @static
     * 
     * @var $requuest
     * 
     * @return bool
     */
    public static function vendor(Request $request)
    {
        if ($request->hasFile('image'))
        {    
            $file = $request->file('image');
            $filename = rand().'-'.$file->getClientOriginalName().'.'.$file->getClientOriginalExtension();
            $path = public_path('images/vendor/'.$filename);
            $avatar = Image::make($file->getRealPath())->resize(100, 80)->save($path);
            // return $filename;
            $image = new Image;
            $image->name = $filename;
            $image->imegeable_id = $request['vendor_id'];
            $image->imageable_type = 'App\Vendor';
            $image->save();
        }
        else{
            return false;
        }

    }
}
