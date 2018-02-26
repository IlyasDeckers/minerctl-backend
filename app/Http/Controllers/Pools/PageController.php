<?php

namespace App\Http\Controllers\Pools;

use Auth;
use App\Wallet;
use Wallets;
use Ethermine;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pools\EthermineController;

class PageController extends EthermineController
{
  protected $currency;
  
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
  * Show the pool dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index($walletAddress, Request $request)
  {
    $currency = Wallet::where('address', strtolower($walletAddress))->first()->currency;
    $stats = Ethermine::getlastStatisticss($walletAddress);
    
    if ($request->ajax()) {
      return [Ethermine::getlastStatisticss($walletAddress)];
    }
    
    return view('pools', [
      'page_title' => 'Pool',
      'wallets' => Auth::user()->wallets,
      'chartjs' => Ethermine::chart($walletAddress),
      'wallet_balance'  => Wallets::getWallet($walletAddress)->value,
      'ethermine_stats' => $stats, 
      'payments' => Ethermine::getPayments(),
      'currency' => $this->currency,
      'wallet_address' => $walletAddress,
      'estimate' => Ethermine::getEstimatedPayout($stats, $currency)
      ]); 
    }
  }
  