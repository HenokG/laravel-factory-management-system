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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'APIControllers'], function () {

    Route::post('/login', 'SessionController@store');

    Route::apiResource('/customers', 'CustomerCompanyController');

    Route::group(['middleware' => 'companyID'], function(){

        Route::get('/performa-nos/{company_id}', 'OrderController@performaNos');

        Route::apiResource('/orders', 'OrderController');

        Route::post('/all-order-descriptions', 'OrderDescriptionController@multiStore');

        Route::apiResource('/order-descriptions', 'OrderDescriptionController');

        Route::apiResource('/requests', 'RequestController');

        Route::apiResource('/agreements', 'AgreementController');

    });

});