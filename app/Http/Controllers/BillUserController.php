<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Bill;
use App\BillUser;

class BillUserController extends Controller
{


    // lấy ra danh sách hóa đơn 
    public function getBillUser(Request $request)
    {
        $pro = DB::table('billuser')
            ->where('idUser', $request->input('idUser'))
            ->where('status', $request->input('status'))
            ->get();

        if (count($pro) > 0) {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'SUCCESS',
                'data' => $pro
            ]);
        } else {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'FALSE',
                'data' => null
            ]);
        }
    }
    // danh sách giỏ hàng 
    public function getBills(Request $request)
    {
        $pro = DB::table('bills')
            ->where('idbill', $request->input('idbill'))
            //->where('status', $request->input('status'))
            ->leftJoin('products', 'bills.idProduct', '=', 'products.id')
            ->select('products.name', 'products.image', 'products.origin', 'bills.*')
            ->get();

        if ($pro != null) {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'DEAILOK',
                'data' => $pro
            ]);
        } else {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'DETAILNULL',
                'data' => null
            ]);
        }
    }

    public function deletebills(Request $request)
    { // ok ok 
        $idProduct = $request->input('idProduct');
        $count = $request->input('count');
        $deletebill = DB::table('bills')
            ->where('id', $request->input('id'))
            ->delete();

            DB::table('products')
            ->where('id', $idProduct)
            ->increment('amount', $count);

        DB::table('products')
            ->where('id', $idProduct)
            ->decrement('saled', $count);

        if ($deletebill == 1) {
            // update lại bảng 
            $check = $this->UpdateCountBillUser($request->input('idbill'));
            if ($check != null) {
                return response()->json([
                    'status' => 'SUCCESS',
                    'mess' => 'DELOK',
                    'data' => null
                ]);
            }
        } else {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'DELFALSE',
                'data' => null
            ]);
        }
    }

    public function bunghang(Request $request)
    {
        $deletebill = DB::table('billuser')
            ->where('id', $request->input('id'))
            ->delete();
        if ($deletebill != null) {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'BUNGOK',
                'data' => null
            ]);
        } else {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'BUNGFALSE',
                'data' => null
            ]);
        }
    }

    public function getCountBill(Request $request)
    {
        $count = DB::table('billuser')
            ->where('idUser', $request->input('idUser'))
            ->where('status', $request->input('status'))
            ->get();

        if (count($count) > 0) {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'SUCCESS',
                'data' => $count
            ]);
        } else {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'FAIL',
                'data' => null
            ]);
        }
    }

    public function AddtoCart(Request $request) // check nếu chưa tồn tại thì tạo mới  ok 
    {
        $idUser = $request->input('idUser');
        $price = $request->input('price');
        $count = $request->input('count');
        $status = $request->input('status');
        $orderdate = $request->input('orderdate');
        $receiveddate = $request->input('receiveddate');

        $voucher = $request->input('voucher');
        $idProduct = $request->input('idProduct');

        $billus = DB::table('billuser') // tìm thằng id user và status = b1 
            ->where('idUser', $idUser)
            ->where('status', $status)
            ->first();

        if ($billus == null) { // chưa có thì tạo thăng mới 
            $id = DB::table('billuser')
                ->insertGetId(
                    [
                        'idUser' => $idUser,
                        'price' =>  $price,
                        'count' => $count,
                        'status' => $status,
                        'orderdate' => $orderdate,
                        'receiveddate' => $receiveddate
                    ]
                );

            $billsIS = array(
                'idBill' => $id,
                'idProduct' => $idProduct,
                'price' => $price,
                'count' => $count,
                'status' => $status,
                'voucher' => $voucher,
                'billdate' => $orderdate,
            );
            $billis = DB::table('bills')
                ->insert($billsIS);

            DB::table('products')
                ->where('id', $idProduct)
                ->increment('saled', 1);

            DB::table('products')
                ->where('id', $idProduct)
                ->decrement('amount', 1);
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'INSERTOK',
                'data' => null
            ]);
        } else {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'EXIST',
                'data' => null
            ]);
        }
    }

    public function AddtoExCart(Request $request) // thêm khi đã có giỏ hàng   ok 
    {

        $price = $request->input('price');
        $count = $request->input('count');
        $status = $request->input('status');
        $orderdate = $request->input('orderdate');

        $voucher = $request->input('voucher');
        $idProduct = $request->input('idProduct');
        $idbill = $request->input('idBill');

        $check = DB::table('bills')
            ->where('idBill', $idbill)
            ->where('idProduct', $idProduct)
            ->where('status', $status)
            ->first();

        if ($check == null) { // them mới
            $billsIS = array(
                'idBill' => $idbill,
                'idProduct' => $idProduct,
                'price' => $price,
                'count' => $count,
                'status' => $status,
                'voucher' => $voucher,
                'billdate' => $orderdate,
            );
            DB::table('bills')
                ->insert($billsIS);

            $check = $this->UpdateCountBillUser($idbill);

            DB::table('products')
                ->where('id', $idProduct)
                ->increment('saled', 1);

            DB::table('products')
                ->where('id', $idProduct)
                ->decrement('amount', 1);

            if ($check == 1) {
                return response()->json([
                    'status' => 'SUCCESS',
                    'mess' => 'UPDATECOUNT',
                    'data' => null
                ]);
            }
        } else {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'FAIL',
                'data' => null
            ]);
        }
    }

    public function Payment(Request $req)
    {
        $status = $req->input('status');
        $idbill = $req->input('idbill');

        DB::table('billuser')
            ->where('id', $idbill)
            ->where('status', $status)
            ->update(
                [
                    'status' => 'b2',
                ]
            );

        $check = DB::table('bills')
            ->where('idBill', $idbill)
            ->where('status', $status)
            ->update(
                [
                    'status' => 'b2',
                ]
            );
        if ($check != null) {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'SUCCESS',
                'data' => null
            ]);
        }
    }

    public function updateCountProduct(Request $req)
    {
        $idpro = $req->input('idpro');
        $count = $req->input('count');


        $check = DB::table('products')
            ->where('id', $idpro)
            ->decrement('amount', $count);

        return response()->json([
            'status' => 'SUCCESS',
            'mess' => 'SUCCESS',
            'data' => null
        ]);
    }


    public function getorder(Request $request)
    {
        $feed = DB::table('billuser')
            ->leftJoin('user1s', 'billuser.idUser', '=', 'user1s.id')
            ->select('user1s.name', 'user1s.address', 'user1s.phone', 'billuser.*')
            ->where('idUser', $request->input('idUser'))
            ->where('status', $request->input('status'))
            ->get();

        return response()->json([
            'status' => 'SUCCESS',
            'mess' => 'SUCCESS',
            'data' => $feed
        ]);
    }






    // các hàm chức năng 

    public function UpdateCountBillUser($id)
    {
        $billsCount = DB::table('bills')
            ->where('idBill', $id)
            ->where('status', 'b1')
            ->get();
        $countBilluser = 0;
        $priceBilluser = 0;
        foreach ($billsCount as $value) {
            $countBilluser += $value->count;
            $priceBilluser += $value->price;
        }

        $check = DB::table('billuser')
            ->where('id', $id)
            ->update(
                [
                    'count' => $countBilluser,
                    'price' => $priceBilluser,
                ]
            );

        return $check;
    }
    public function totalmoney($idBill, $status)
    {
        $pro = DB::table('bills')
            ->where('idbill', $idBill)
            ->where('status', $status)
            ->get();
        $total = 0;
        foreach ($pro as $t) { // lấy ra list product tương đương với bills
            $total += $t->count * $t->price;
        }

        return $total;
    }
}
