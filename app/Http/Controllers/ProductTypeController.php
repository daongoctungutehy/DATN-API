<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\User1;
class ProductTypeController extends Controller
{
    public function getAllLoaiSp(){
        $producttype = DB::table('product_types')->get();
        return response()->json($producttype);
    }
    

}
