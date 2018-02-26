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
    if($data['response'] === []) {
			return response()->json('No Data',200);
    }
    $store = new \App\MinerStatistics();
    $store->user_id = $data['userId'];
    $store->rigname = $data['rigname'];
    $store->data = json_encode($data['response']);

    try {
        $store->save();
        return response()->json($store, 200);
    } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
    }
});

Route::middleware('auth:api')->post('data/notification', function (Request $request) {
    $data = $request->data;

    $store = new \App\Notifications();
    $store->user_id = $data['userId'];
    $store->message = $data['message'];
    $store->read = 0;
    $store->type = $data['type'];

    try {
        $store->save();
        return response()->json($store, 200);
    } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
    }
});

Route::middleware('auth:api')->get('/rigs', 'Rigs\RigsController@getRigs');
Route::middleware('auth:api')->get('/rigs/statistics', 'Rigs\RigsController@getRigsStatistics');
