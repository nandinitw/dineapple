<?php

use Illuminate\Http\Request;

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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::get('outlets', 'API\OutletController@index');
Route::get('tables', 'API\TablesController@index');
Route::post('mapdevicetotable','API\TableDeviceController@mapdevicetotable');
Route::post('clearmappings','API\TableDeviceController@clearmappings');
//user authentication call
Route::get('verify', 'API\VerificationController@verifyuser');
Route::get('validate', 'API\VerificationController@login');
Route::post('registerapiuser', 'API\VerificationController@register');
Route::get('passwordlogin', 'API\VerificationController@passwordlogin');
Route::get('customers', 'API\VerificationController@getusers');

//Route::group(['middleware' => 'auth:api'], function(){
    Route::get('checkuser', 'API\VerificationController@getuserDetails');
//});
//tablet setting api
Route::get('hotellist', 'API\SettingsController@index');
Route::get('outletlist', 'API\SettingsController@getOutlets');
Route::post('registerapp', 'API\SettingsController@registerApp');
Route::get('fetchapp', 'API\SettingsController@fetchAppSettings');
//menu access and lisitng call
Route::get('getmenulist', 'API\MenuController@getmenulist');
Route::get('itemlist', 'API\MenuController@getitemlist');
Route::post('addtocart', 'API\MenuController@addtocart');
//Ratings API
Route::get('ratings', 'API\RatingController@ratings');
Route::post('rate-experience','API\RatingController@rate_experience');
Route::get('waiter_ratings','API\RatingController@waiter_ratings');
Route::post('rate_customer','API\RatingController@rate_customer');
//Attributes API
Route::get('attributes/{section}','API\AttributesController@attributes');
//Order API
Route::post('placeorder','API\OrderController@instockorder');
Route::get('orderlist','API\OrderController@getOrders');
Route::get('customerorderlist','API\OrderController@getCustomerOrders');
Route::get('orderdetails','API\OrderController@getOrderDetails');
Route::post('updateorderstatus','API\OrderController@updateOrderStatus');