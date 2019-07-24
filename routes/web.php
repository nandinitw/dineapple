<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', 'Auth\LoginController@login');
Route::get('/', 'HomeController@index')->name('home');

//,'middleware'=>'auth:api'
Route::group(['prefix'=>'api' ], function(){
    Route::get('/user/edit/{id}', 'UsersController@edit'); 
});

Route::get('/home', 'HomeController@index');
Route::get('/admin', 'HomeController@index');
Route::get('/users/{id}/edit', 'UsersController@edit');
Route::post('/users', 'UsersController@store');


Route::group(['middleware' => 'auth'], function() {
 
    Route::match(array('GET', 'POST'), "/users", array(
        'uses' => 'UsersController@index',
        'as' => 'filter'
    ));

    Route::group(['middleware' => 'is_superadmin'], function() {
        //restaurant
        Route::Resource('hotels', 'HotelsController');
        Route::post('/hotels/delete','HotelsController@batchDelete');
        Route::post('/hotels/status','HotelsController@updateStatus');
        Route::get('/hotels/{id}/delete','HotelsController@destroy');
        //outlets
        Route::Resource('outlets', 'OutletsController');
        Route::post('/outlets/delete','OutletsController@batchDelete');
        Route::post('/outlets/status','OutletsController@updateStatus');
        Route::get('/outlets/{id}/delete','OutletsController@destroy'); 
        //role
        Route::Resource('roles','RolesController');
        Route::post('/roles/delete','RolesController@batchDelete');
        Route::post('/roles/status','RolesController@updateStatus');
        Route::get('/roles/{id}/delete','RolesController@delete');
        //ratings
        Route::Resource('ratings', 'RatingsController');
        Route::post('/ratings/delete','RatingsController@batchDelete');
        Route::post('/ratings/status','RatingsController@updateStatus');
        Route::get('/ratings/{id}/delete','RatingsController@destroy');
        Route::post('/ratings/update','RatingsController@update');

        //attributes
        Route::Resource('attributes','AttributesController');
        Route::get('attributes/{id}/delete','AttributesController@delete');
        Route::post('attributes/delete','AttributesController@batchDelete');
    });
    
    Route::group(['middleware' => 'is_outletadmin'], function() {
        Route::Resource('assignattributes', 'AssignAttributesController');
        Route::Resource('assignratings', 'AssignratingsController');
    
        //users
        Route::Resource('users','UsersController');
        Route::post('/users/delete','UsersController@batchDelete');
        Route::post('/users/status','UsersController@updateStatus');
        Route::get('/users/{id}/delete','UsersController@delete');
    
        //menugroups
        Route::Resource('menugroups','MenugroupController');
        Route::post('/menugroups/delete','MenugroupController@batchDelete');
        Route::post('/menugroups/status','MenugroupController@updateStatus');
        Route::get('/menugroups/{id}/delete','MenugroupController@delete');
        //menuitems
        Route::Resource('menuitems','MenuitemsController');
        Route::post('/menuitems/delete','MenuitemsController@batchDelete');
        Route::post('/menuitems/status','MenuitemsController@updateStatus');
        Route::get('/menuitems/{id}/delete','MenuitemsController@destroy');

        //orders
        Route::Resource('orders', 'OrderController');
        Route::post('orders/updatestatus','OrderController@updateStatus');
        Route::get('orders/trash/{id}','OrderController@trash');

        //Feedbacks
        Route::get('customerfeedback','FeedbackController@getCustomerfeedback');
        Route::get('viewfeedback/{id}','FeedbackController@viewFeedback');
    });



    //offers
    Route::Resource('offers', 'OffersController');
    Route::post('/offers/delete','OffersController@batchDelete');
    Route::post('/offers/status','OffersController@updateStatus');
    Route::get('/offers/{id}/delete','OffersController@destroy'); 
    Route::post('/offers/update','OffersController@update');

    //Pages
    Route::Resource('pages', 'PagesController');
    Route::post('/pages/delete','PagesController@batchDelete');
    Route::post('/pages/status','PagesController@updateStatus');
    Route::get('/pages/{id}/delete','PagesController@destroy'); 

    
});


//order
/*Route::get('/orderlist', 'OrderController@index');
Route::get('/order/{id}/show', 'OrderController@show');
Route::match(array('GET', 'POST'), "/orderfilter", array(
    'uses' => 'OrderController@filter',
    'as' => 'filter'
));*/

//Pages
Route::Resource('pages', 'PagesController');
Route::post('/pages/delete','PagesController@batchDelete');
Route::post('/pages/status','PagesController@updateStatus');
Route::get('/pages/{id}/delete','PagesController@destroy'); 
//ajax call
Route::post('/menugroup/update','MenugroupController@update');
Route::post('/menuitem/update','MenuitemsController@update');
Route::post('/ajaximage/upload', 'AjaxController@upload');
Route::post('/getoutlets','OutletController@outlets');

Route::prefix('manage')->group(function () {
    Route::namespace('Manage')->group(function(){
        Route::resource('tables','TablesController')->middleware('is_outletadmin');
        Route::get('tables/{id}/delete','TablesController@delete')->middleware('is_outletadmin');
        Route::post('tables/delete','TablesController@batchDelete')->middleware('is_outletadmin');
    });
    
});


Route::get('/foo', function () {
Artisan::call('storage:link');
});

//Run in server. One time to generate application keys
Route::get('/keygenerate', function () {
    Artisan::call('key:generate');
});

Auth::routes();

//menulist for public users
Route::get('/menulist','FrontendController@listitems');
Route::get('/menu/{id}/list','FrontendController@itemlist');
Route::get('/cartlist','CartController@index');
//ajaxcall
Route::post('/addtocart','CartController@addtocart');
Route::get('/listcart','CartController@viewcart');
Route::post('/cart/checkout','CartController@checkout');
//ajaxcall

//Route::get('/ajaxImageUpload', ['uses'=>'AjaxImageUploadController@ajaxImageUpload']);
//Route::post('/ajaxImageUpload', ['as'=>'ajaxImageUpload','uses'=>'AjaxImageUploadController@ajaxImageUploadPost']);


//Route::resource('tables','TablesController');
