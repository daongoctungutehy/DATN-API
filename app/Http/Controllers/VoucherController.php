<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class VoucherController extends Controller
{
    public function checkVoucher(Request $request){
        $voucher=$request->input('voucher');
        $idProduct=$request->input('idProduct');
        $pro = DB::table('vouchers')
        ->where('idProduct',$idProduct)
        ->where('voucher',$voucher)
        ->whereDate('endDate', '>=', date("Y-m-d"))
        ->first();
        return response()->json($pro);
    }
}
