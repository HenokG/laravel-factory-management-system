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

use App\Company;

Route::post('excel', 'ProformaOrderController@store');

Route::get('proformas', 'ProformaOrderController@index');

Route::get('proforma/{id}', 'ProformaOrderController@show');

Route::post('deliveries', 'DeliveryOrderController@store');

Route::get('deliveries', 'DeliveryOrderController@index');

Route::post('delivery/{id}', 'DeliveryOrderController@sendToProduction');

Route::get('delivery/{id}', 'DeliveryOrderController@show');

Route::get('/new/orders', 'ProformaOrderController@index');

Route::redirect('/', '/login');

Route::get('/login', 'SessionController@create');

Route::post('/login', 'SessionController@store');

Route::get('/signup', 'CompaniesController@create');

//don't need authenticatedmiddleware cause company creation can
//be performed by guest users
Route::put('/company', 'CompaniesController@store');

Route::get('/logout', 'SessionController@destroy');
Route::get('/factorymanager/logout', 'SessionController@destroy');
Route::get('/productionmanager/logout', 'SessionController@destroy');

Route::group(['middleware' => ['authenticated','accountType']], function () {

    //Admin Module Routes
    Route::get('/companies', 'CompaniesController@index');

    Route::patch('/company/{company}', 'CompaniesController@update');

    Route::delete('/company/{company}', 'CompaniesController@destroy');

    //used for password changing of user by admin
    Route::patch('/user/{user}', 'UsersController@update');



    //Sales Module Routes
    Route::get('/customers', function(){
        return view('sales.dashboard');
    });

    Route::get('/agreements', 'AgreementController@index');

    Route::put('/agreement', 'AgreementController@store');

    Route::delete('/agreement/{id}', 'AgreementController@destroy');


    //Production Manager Module Routes
    Route::get('/productionmanager/orders', 'OrderController@index');

    Route::get('/productionmanager/order-description', 'OrderDescriptionController@show');

    Route::post('/productionmanager/obstacle', 'ObstacleController@store');

});
