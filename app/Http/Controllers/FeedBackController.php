<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\FeedbackProduct;
class FeedBackController extends Controller
{
    public function getfeedback(Request $request){
        $feed = DB::table('feedback_products')
        ->leftJoin('user1s', 'feedback_products.idUser', '=', 'user1s.id')
        ->select('user1s.name','user1s.imagefb', 'feedback_products.*')
        ->where('idProduct', $request->input('idProduct'))
        ->orderBy('rate', 'desc') // sắp xếp giảm dần
        ->paginate(5);
        return response()->json($feed);
    }

    public function pushFeedback(Request $request){
        $feed=new FeedbackProduct();

        $feed->idProduct=$request->input('idproduct');
        $feed->idUser=$request->input('idUser');
        $feed->content=$request->input('content');
        $feed->feedDate=$request->input('feedDate');
        $feed->rate=$request->input('rate');
        $feed->save();

        $avgpro = DB::table('feedback_products')
                ->where('idProduct',$request->input('idproduct'))
                ->avg('rate');
               
                $hmm= DB::table('products')
                ->where('id', $request->input('idproduct'))
                ->update(['rate' => $avgpro]);

                return response()->json($hmm);

    }
}
