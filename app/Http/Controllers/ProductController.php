<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
class ProductController extends Controller
{
    public function getAll1(Request $request){

        $type = $request->input('typesort');
        $origin = $request->input('origin');
        return $this->loadspne($type,$origin);
       }

      

       public function getCount(){ 
        $count = Product::count(); 
        return response()->json($count);
       }
       // trả về detail của sản phẩm 
       public function getimageSP(Request $request){
        $user = DB::table('image_products')->where('idProduct',$request->input('id'))->get();
        return response()->json($user);
       }
       public function getSPLQ(Request $request){ // sản phẩm liên quan 
        $user = DB::table('products')->where('idProductType',$request->input('idProductype'))->paginate(5);
        return response()->json($user);
       }
       

       public function getfullSPLQ(Request $request){ // full sản phẩm liên quan 
        $user = DB::table('products')->where('idProductType',$request->input('idProduct'))->get();
        return response()->json($user);
       }
       public function getfullfeedback(Request $request){ // full feedback
        $user = DB::table('feedback_products')->where('idProduct',$request->input('idProduct'))->get();
        return response()->json($user);
       }
       // sản phẩm liên quan
       public function getproType(Request $request){
        $pro = DB::table('products')->where('idProductType',$request->input('idProductType'))->paginate(16);
        return response()->json($pro);
       }

       // method 

       public function loadspne($typesort,$typrorigin){
        if($typrorigin==00){
            if($typesort == 1){ // thấp đến cao 
                $pro = DB::table('products')
                ->orderBy('price')
                ->paginate(15);
                return response()->json($pro);
            }elseif($typesort==0){
                    $pro = DB::table('products')
                    ->paginate(15);
                    return response()->json($pro);  
            }
            elseif($typesort==2){
                $pro = DB::table('products')
                ->orderByDesc('price')
                ->paginate(15);
                return response()->json($pro);  
             }

        }else{
            if($typesort == 1){ 
                $pro = DB::table('products')
                ->orderBy('price')
                ->where('idProductType',$typrorigin)
                ->paginate(15);
                return response()->json($pro);
            }elseif($typesort==0){
                    $pro = DB::table('products')
                    ->where('idProductType',$typrorigin)
                    ->paginate(15);
                    return response()->json($pro);  
            }elseif($typesort==2){
                $pro = DB::table('products')
                ->orderByDesc('price')
                ->where('idProductType',$typrorigin)
                ->paginate(15);
                return response()->json($pro);  
            }   
        }
       
       }
 
}
