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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/user/profile', 'UserController@index')->name('userProfile');

Route::get('/dashboard', 'HomeController@index')->name('dashboard');

Route::get('/mining/{walletAdress}', 'Pools\PageController@index')->name('pools');
/*Route::get('/mining/add', 'Pools\PageController@index')->name('addPool');
Route::get('/mining/delete', 'Pools\PageController@index')->name('deletePool');*/

Route::get('/wallets', 'Wallet\WalletController@index');
Route::get('/wallet/create', 'Wallet\WalletController@createWallet')->name('createWallet');
Route::get('/wallet/{walletAdress}', 'Wallet\WalletController@index')->name('wallets');


Route::get('/rigs', 'Rigs\RigController@index')->name('rigs');