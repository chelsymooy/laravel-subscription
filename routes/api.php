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

Route::namespace('API')->group(function() {
	Route::get('plans', 						'PlanAPIController@index');
	
	Route::middleware('auth:api')->group(function() {
		Route::get('subscriptions',				'SubscriptionAPIController@index');
		Route::post('subscriptions', 			'SubscriptionAPIController@store');
		Route::patch('subscriptions/{id}', 		'SubscriptionAPIController@update');
		
		Route::get('subscriptions/{subscription_id}/bills',		'BillAPIController@index');
	});
});
