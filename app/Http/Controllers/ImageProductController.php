<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
class ImageProductController extends Controller
{
    public function getproImage(Request $request){
        $pro = DB::table('image_products')->where('idProduct',$request->input('id'))->get();
        return response()->json($pro);
       }
 
}
