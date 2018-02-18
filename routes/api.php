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

Route::middleware('auth:api')->get('/wallets', function (Request $request) {
    return response()->json(
    	$request->user()->wallets
   	);
});

Route::middleware('auth:api')->get('/wallet/{walletAddress}', function ($walletAddress) {
    return response()->json(
    	Wallets::getWallet($walletAddress), 200
    );
});

Route::middleware('auth:api')->get('/wallet/transactions/{walletAddress}', function ($walletAddress) {
	return response()->json(
    	Wallets::getTransactions($walletAddress), 200
    );
});

Route::middleware('auth:api')->get('/pools/{walletAddress}', 'Pools\PageController@index');