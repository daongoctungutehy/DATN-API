<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Banner;
class BannerController extends Controller
{
    public function getBanner(){
        $banner = DB::table('banners')->get();
        return response()->json($banner);
       }
       public function getProductWithId(Request $request){
        $pro=Product::where('id',$request->input('id'))->get();
        return response()->json($pro);
       }


       public function uploadImage(Request $rq){
        $posts =  $rq->file('image');
        $fileExtension = $rq->file('image')->getClientOriginalExtension(); // Lấy . của file
        $fileName = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension;
         $uploadPath = public_path('image/banner/');
       // $uploadPath = $part.'image/banner/';
        $rq->file('image')->move($uploadPath, $fileName);
        $path='image/banner/'.$fileName;
        $banner = new Banner();
        $banner->idProduct = $rq->input('idproduct');
        $banner->image = $path;
        $banner->save();
        
        return response()->json($banner);
        }
}
