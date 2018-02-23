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

Route::middleware('auth:api')->post('data/claymore', function (Request $request) {
    $data = $request->data;

    $store = new \App\MinerStatistics();
    $store->user_id = $data['userId'];
    $store->rigname = $data['rigname'];
    $store->data = json_encode($data['response']);

    try {
        $store->save();
        return response()->json($store, 200);
    } catch (\Exception $e) {
        throw new \Exception($e->getMessage());
    }
});

Route::middleware('auth:api')->get('/rigs', 'Rigs\RigsController@getRigs');
Route::middleware('auth:api')->get('/rigs/statistics', 'Rigs\RigsController@getRigsStatistics');
