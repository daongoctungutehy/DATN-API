<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// tesst ssssssssssssssss
Route::get('getAll', 'TestController@getAll')->name('getAll');
Route::post('insert', 'TestController@insert')->name('insert');
Route::post('search', 'TestController@search')->name('search');
Route::post('update', 'TestController@update')->name('update');
Route::post('delete', 'TestController@delete')->name('delete');

Route::post('testne', 'TestController@testne')->name('testne');
// tesst 

Route::post('insert', 'TestController2@insert')->name('insert');
Route::post('getBanner1', 'TestController2@getBanner1')->name('getBanner1');
// bắt đầu 
Route::get('getBanner', 'BannerController@getBanner')->name('getBanner');
Route::post('getProductWithId', 'BannerController@getProductWithId')->name('getProductWithId');
Route::post('uploadImagebanner', 'BannerController@uploadImage')->name('uploadImage');
// user 
Route::post('RegisterNomal', 'User1sController@RegisterNomal')->name('RegisterNomal');
Route::post('loginNomal', 'User1sController@loginNomal')->name('loginNomal');
Route::post('getAccount', 'User1sController@getAccount')->name('getAccount');
Route::post('ConnectWithFacebook', 'User1sController@ConnectWithFacebook')->name('ConnectWithFacebook');
Route::post('RegisterFacebook', 'User1sController@RegisterFacebook')->name('RegisterFacebook');
Route::post('updateUser', 'User1sController@updateUser')->name('updateUser');

// upload hình ảnh
Route::post('uploadImage', 'User1sController@uploadImage')->name('uploadImage');
// product
Route::post('getAll1', 'ProductController@getAll1')->name('getAll1'); 
Route::get('getCount', 'ProductController@getCount')->name('getCount');
// product detail 
Route::post('getproType', 'ProductController@getproType')->name('getproType');
Route::post('getimageSP', 'ProductController@getimageSP')->name('getimageSP');
Route::post('getSPLQ', 'ProductController@getSPLQ')->name('getSPLQ'); 
Route::post('getfullSPLQ', 'ProductController@getfullSPLQ')->name('getfullSPLQ'); 
Route::post('getfullfeedback', 'ProductController@getfullfeedback')->name('getfullfeedback');
Route::post('getproImage', 'ImageProductController@getproImage')->name('getproImage');
// product type 
Route::get('getAllLoaiSp', 'ProductTypeController@getAllLoaiSp')->name('getAllLoaiSp');

Route::post('searchProduct', 'SearchController@searchProduct')->name('searchProduct');
Route::post('searchByid', 'SearchController@searchByid')->name('searchByid');

Route::post('checkVoucher', 'VoucherController@checkVoucher')->name('checkVoucher');

Route::post('getfeedback', 'FeedBackController@getfeedback')->name('getfeedback');
Route::post('pushFeedback', 'FeedBackController@pushFeedback')->name('pushFeedback');
// bill
Route::post('CreateBill', 'BillController@CreateBill')->name('CreateBill');
// Route::post('getBill', 'BillController@getBill')->name('getBill');
Route::post('updateBill', 'BillController@updateBill')->name('updateBill');
// Route::post('deleteBill', 'BillController@deleteBill')->name('deleteBill');
Route::post('orderProduct', 'BillController@orderProduct')->name('orderProduct');
Route::post('loadDetailBillWithID', 'BillController@loadDetailBillWithID')->name('loadDetailBillWithID');



// bill v2
Route::post('CreateBillUser', 'BillUserController@CreateBillUser')->name('CreateBillUser');
Route::post('getCountBill', 'BillUserController@getCountBill')->name('getCountBill');
Route::post('getBills', 'BillUserController@getBills')->name('getBills');
Route::post('deletebills', 'BillUserController@deletebills')->name('deletebills');
Route::post('Updatebills', 'BillController@Updatebills')->name('Updatebills');
Route::post('Payment', 'BillUserController@Payment')->name('Payment');
Route::post('updateCountProduct', 'BillUserController@updateCountProduct')->name('updateCountProduct');
Route::post('getorder', 'BillUserController@getorder')->name('getorder');

Route::post('AddtoCart', 'BillUserController@AddtoCart')->name('AddtoCart');
Route::post('AddtoExCart', 'BillUserController@AddtoExCart')->name('AddtoExCart');









