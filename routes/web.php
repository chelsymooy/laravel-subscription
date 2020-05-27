<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the SubscriptionsServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login',		['uses' => 'AuthController@get', 		'as' => 'subs.login.get']);
Route::post('login',	['uses' => 'AuthController@post', 		'as' => 'subs.login.post']);
Route::get('logout',	['uses' => 'AuthController@logout',		'as' => 'subs.logout']);

Route::middleware('subs:web')->group(function() {
	Route::get('dashboard',	['uses' => 'DashboardController@index',	'as' => 'subs.dashboard.index']);

	Route::resource('plans',			'PlanController')->names([
	    'index'  => 'subs.plans.index',
	    'create' => 'subs.plans.create',
	    'store'  => 'subs.plans.store',
	    'show'   => 'subs.plans.show',
	    'edit' 	 => 'subs.plans.edit',
	    'update' => 'subs.plans.update',
	    'destroy'=> 'subs.plans.destroy'
	]);

	Route::resource('plans/{plan_id}/prices',	'PriceController')->names([
	    'create' => 'subs.prices.create',
	    'store'  => 'subs.prices.store',
	    'edit' 	 => 'subs.prices.edit',
	    'update' => 'subs.prices.update',
	    'destroy'=> 'subs.prices.destroy'
	])->only('create', 'store', 'edit', 'update', 'destroy');

	Route::resource('subscriptions',			'SubscriptionController')->names([
	    'index'  => 'subs.subscriptions.index',
	    'create' => 'subs.subscriptions.create',
	    'store'  => 'subs.subscriptions.store',
	    'show'   => 'subs.subscriptions.show',
	    'edit' 	 => 'subs.subscriptions.edit',
	    'update' => 'subs.subscriptions.update'
	])->except('destroy');

	Route::resource('subscriptions/{subscription_id}/bills',	'BillController')->names([
	    'show'   => 'subs.bills.show',
	    'edit' 	 => 'subs.bills.edit',
	    'update' => 'subs.bills.update'
	])->only('show', 'edit', 'update');
	
	Route::patch('subscriptions/{subscription_id}/bills/{bill_id}/pay',	['uses' => 'BillController@pay',	'as' => 'subs.bills.pay']);
});
