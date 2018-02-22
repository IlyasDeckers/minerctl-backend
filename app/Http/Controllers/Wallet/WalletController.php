<?php

namespace App\Http\Controllers\Wallet;

use Auth;
use Wallets;
use Ethereum;
use Exception;
use App\Wallet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class WalletController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }
  
  /**
   * Show the wallet dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  public function index($walletAddress)
  {
    return view('wallet', [
      'balance'       => (object) Wallets::getWallet($walletAddress),
      'currency'      => Wallets::getCurrency($walletAddress, true),
      'transactions'  => Wallets::getTransactions($walletAddress),
      'address'       => $walletAddress,
      'wallets'       => Wallets::getWallets()
    ]); 
  }


  /**
   * Show the create wallet page. The wallet creation 
   * is handeled completely client-side. No sensitive 
   * information is processed and stored server side.
   * 
   * See resources/assets/js/app.js for more information
   * 
   * @return \Illuminate\Http\Response
   */
  public function createWallet()
  {
    return view('createwallet');
  }

  public function addWallet(Request $request)
  {
    if (strpos($request->address, '0x') !== false) { 
      $address = $request->address; 
    } else {
      $address = '0x' . $request->address; 
    }

    try {
      $eth = Ethereum::eth_getBalance($address);
    } catch (\Exception $e) {
      return redirect()->back()->with('walletError', 'Invalid address!');
    }

    try {
      $w = new Wallet();
      $w->address = $address;
      $w->currency = 'eth';
      $w->user_id = Auth::user()->id;
      $w->save();
    } catch (Exception $e) {
      return redirect()->back()->with('walletError', 'This address is already present in our database!');
    }

    return redirect('/dashboard');
  }
}