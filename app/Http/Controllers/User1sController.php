<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\User1;
class User1sController extends Controller
{
    public function RegisterNomal(Request $request){ // cần kiểm tra xem có tài khoản hoặc email nào đó chưa 
        $user=new User1();
        $user->account=$request->input('account');
        $user->password=$request->input('password');
        $user->email=$request->input('email');
        $user->address=$request->input('address');
        $user->phone=$request->input('phone');
        $user->name=$request->input('name');
        $user->imagefb=$request->input('imagefb');

        $acc=User1::where('account',$request->input('account'))->first();
        $mail=User1::where('email',$request->input('email'))->first();
        if($acc!=null){
        return response()->json([
            'status' => 'SUCCESS',
             'mess' => 'EXISTACC',
            'data'=> null
            ]);
        }

        if($mail!=null){
            return response()->json([
                'status' => 'SUCCESS',
                 'mess' => 'EXISTMAIL',
                'data'=> null
                ]);
            }

       else{
            $user->save();
            return response()->json([
                'status' => 'SUCCESS',
                 'mess' => 'SUCCESS',
                'data'=> $user
                ]);
        }
    }
    public function RegisterFacebook(Request $request){
        $user=new User1();
        $user->idfb=$request->input('idfb');
        $user->fbName=$request->input('fbName');
        $user->imagefb=$request->input('imagefb');
        $user->address=$request->input('address');
        $user->phone=$request->input('phone');
        $user->name=$request->input('fbName');

        $acc=User1::where('idfb',$request->input('idfb'))->first();
        if($acc!=null){
            return response()->json([
                'status' => 'SUCCESS',
                 'mess' => 'REGOK',
                'data'=> $acc
                ]);
        }else{
            $user->save();
            return response()->json([
                'status' => 'SUCCESS',
                 'mess' => 'REGOK',
                'data'=> $user
                ]);
        }
    }


    public function ConnectWithFacebook(Request $request){
       

        $id = $request->input('id');

        $idfb=$request->input('idfb');
        $fbname=$request->input('fbName');
        $imgfb=$request->input('imagefb');
        $address=$request->input('address');
        $phone=$request->input('phone');
        
        $check=DB::table('user1s')
        ->where('id', $id)
        ->update(
            [
            'idfb' => $idfb,
            'fbName'=>$fbname,
            'imagefb'=>$imgfb,
            'address'=>$address,
            'phone'=>$phone,
            'name'=>$fbname,
            ]
        );
        if($check==1){
            return response()->json([
                'status' => 'SUCCESS',
                 'mess' => 'liên kết tài khoản thành công ',
                'data'=> null
                ]);
            }
    }

    public function getAccount(Request $request){
        $id=$request->input('id');

        $user = DB::table('user1s')
        ->where('id',$id)
        ->first();

        if($user == null){
            return response()->json([
                'status' => 'SUCCESS',
                 'mess' => 'FAIL',
                'data'=> null
                ]);
        }else{
         return response()->json([
            'status' => 'SUCCESS',
            'mess' => 'SUCCESS',
            'data'=> $user
             ]);
        }
       
    }

    public function loginNomal(Request $request){
        $tk=$request->input('account');
        $mk=$request->input('password');
        
        $user = DB::table('user1s')
        ->where('account',$tk)
        ->where('password',$mk)->first();
        if($user == null){
            return response()->json([
                'status' => 'SUCCESS',
                 'mess' => 'FAIL',
                'data'=> null
                ]);
        }else{
                return response()->json([
                    'status' => 'SUCCESS',
                     'mess' => 'SUCCESS',
                    'data'=> $user
                    ]);
        }
       
    }

    public function updateUser(Request $request) // insert Array list 
    {
      $data =  json_decode($request->getContent(), true); // ok ok ne
     //  foreach ($data as $value) {  // ddocj json nef 
     //   dd($value['user']);
     //  }
     $last_id = DB::table('user1s')
     ->where('id',$data['id'])
       ->update($data);

       return response()->json([
        'status' => 'SUCCESS',
         'mess' => 'SUCCESS',
        'data'=> null
        ]);
    }


    public function uploadImage(Request $rq){
        $posts =  $rq->file('image');
        $fileExtension = $rq->file('image')->getClientOriginalExtension(); // Lấy . của file
        $fileName = time() . "_" . rand(0,9999999) . "_" . md5(rand(0,9999999)) . "." . $fileExtension;
        $uploadPath = public_path('image/user1s/');
        $rq->file('image')->move($uploadPath, $fileName);
        $path='image/user1s/'.$fileName;
        return response()->json($path);
        }


}
