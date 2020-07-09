<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController2 extends Controller
{
  public function login(Request $request)
  {
    $taikhoan = $request->input('tk'); // lấy ra từ phía client gửi lên
    $matkhau = $request->input('mk');
    $users = DB::table('test')
      ->where('user', $taikhoan)
      ->where('pass', $matkhau)->get();

    return response()->json($users);
  }

  public function insert(Request $request1)
  {
    $data = array(
      'user' => $request1->input('tk'),
      'pass' => $request1->input('mk'),
    );
    $last_id = DB::table('test')
      ->insertGetId($data); // insert và lấy ra id cuối cùng của bảng
    return response()->json($last_id);
  }

  public function getBanner1()
  {
    $banner = DB::table('user1s')->get();
    return response()->json($banner);
  }
}
