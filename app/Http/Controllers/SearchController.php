<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;

class SearchController extends Controller
{
    public function searchProduct(Request $request){
        $name=$request->input('name');
        $users = DB::table('products')
                ->where('name', 'like', "%{$name}%")
                ->orWhere('describe', 'like',"%{$name}%")
                ->get();
         return response()->json($users);
    }

    public function searchByid(Request $request){
        $id=$request->input('id');
        $pro = DB::table('products')
        ->where('id',$id)->first();
        return response()->json($pro);
        
    }
}
