<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function getAll(){
        $sanphamtt = DB::table('test')->get();
        return response()->json($sanphamtt);
       }
       public function insert(Request $request1)
       {
           $id = $request1->input('id'); // lấy ra từ phía client gửi lên
           $title = $request1->input('title');
           $description = $request1->input('description');
           $priority = $request1->input('priority');
          // $img = $request1->input('img');
    
          DB::table('note1')->insert([
        ['id' => $id,
         'title' =>  $title,
         'description' => $description,
         'priority' => $priority,
        // 'img' =>  $img
         ]]);
       }

       public function search(Request $request1){
        $id = $request1->input('id');
       $note1 = DB::table('note1')
                ->where('id', $id)->get();
      return response()->json($note1);
       }

       public function update(Request $req)
       {
           $id = $req->input('id');
           $tit = $req->input('title');
           $des = $req->input('description');
           $pri = $req->input('priority');

           $note1= DB::table('note1')
        ->where('id', $id)
        ->update([
          'title' => $tit,
          'description' => $des,
          'priority' => $pri
          ]);
          return response()->json($note1);
       }

       public function delete(Request $reg1){
        $id = $reg1->input('id');
       $note1 = DB::table('note1')->where('id', '=', $id)->delete();
      return response()->json($note1);
       }


       public function testne(Request $request) // insert Array list 
       {
         $data =  json_decode($request->getContent(), true); // ok ok ne
        //  foreach ($data as $value) {  // ddocj json nef 
        //   dd($value['user']);
        //  }
        $last_id = DB::table('test')
          ->insert($data);
        return response()->json($last_id);
       }


}