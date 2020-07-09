<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Bill;

class BillController extends Controller
{

    public function getBill(Request $request)  // ok 
    { //lay san pham da dat hang
        $pro = DB::table('bills')
            ->where('idBill', $request->input('idBill'))
            ->where('status', $request->input('status'))
            ->leftJoin('products', 'bills.idProduct', '=', 'products.id')
            ->select('products.name', 'products.image', 'products.origin', 'bills.*')
            ->get();
        return response()->json([
            'status' => 'SUCCESS',
            'mess' => 'MESS',
            'data' => $pro
        ]);
    }

    public function deleteBill(Request $request)
    {
        $deletebill = DB::table('bills')
            ->where('idBill', $request->input('idBill'))
            ->where('idProduct', $request->input('idProduct'))
            ->delete();

        return response()->json($deletebill);
    }

    public function Updatebills(Request $request) // xử lý tăng giảm trong giỏ hàng 
    {
        $id = $request->input('id');
        $idbill = $request->input('idbill');
        $count = $request->input('count');
        $stt = $request->input('status');
        $idProduct = $request->input('idProduct');
        $saled = $request->input('saled');

        $udbill = DB::table('bills')
            ->where('id', $id)
            ->where('status', $stt)
            ->update(
                [
                    'count' => $count,
                ]
            );
        DB::table('products')
            ->where('id', $idProduct)
            ->increment('saled', $saled);

        DB::table('products')
            ->where('id', $idProduct)
            ->decrement('amount', $saled);

        if ($udbill == 1) {
            $check = $this->UpdateCountBillUser($idbill);
            if ($check != null) {
                return response()->json([
                    'status' => 'SUCCESS',
                    'mess' => 'UPDATEOK',
                    'data' => null
                ]);
            }
        } else {
            return response()->json([
                'status' => 'SUCCESS',
                'mess' => 'UPDATEFALSE',
                'data' => null
            ]);
        }
    }

    public function getCountBill(Request $request)
    {
        $count = DB::table('bills')
            ->where('idUser', $request->input('idUser'))
            ->where('status', $request->input('status'))
            ->count();
        return response()->json($count);
    }

    // đặt hàng
    public function orderProduct(Request $request)
    {
        $count = DB::table('bills')
            ->where('idUser', $request->input('idUser'))
            ->where('status', $request->input('status'))
            ->update(
                [
                    'status' => $request->input('statusUpdate')
                ]
            );

        $bills = DB::table('bills') // lấy ra danh sách bills
            ->where('idUser', $request->input('idUser'))
            // ->where('idProduct',$request->input('idProduct'))
            ->where('status', 'b2')
            ->get();

        $product = array();
        foreach ($bills as $t) { // lấy ra list product tương đương với bills
            $pro = DB::table('products')
                ->where('id', $t->idProduct)
                ->get()->first();
            array_push($product, $pro);
        }
        foreach ($product as $i) {
            $idproduct = $i->id;
            foreach ($bills as $j) {
                if ($j->idProduct == $idproduct) {
                    $amoutupdate = $i->amount - $j->count;
                    DB::table('products')
                        ->where('id', $i->id)
                        ->update(
                            [
                                'amount' => $amoutupdate
                            ]
                        );
                }
            }
        }
        return response()->json([
            'status' => 'SUCCESS',
            'mess' => 'ORDER',
            'data' => null
        ]);
    }

    public function loadDetailBillWithID(Request $request) // load danh sách đơn hàng theo id đơn 
    {
        $bill = DB::table('bills')
            ->where('idBill', $request->input('idBill'))
            ->leftJoin('products', 'bills.idProduct', '=', 'products.id')
            ->select('products.name', 'products.image', 'products.origin', 'bills.*')
            ->get();
        return response()->json([
            'status' => 'SUCCESS',
            'mess' => 'danh sách sản phẩm',
            'data' => $bill
        ]);
    }



    // method chức năg 
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
            $priceBilluser += $value->price * $value->count;
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
}
