<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Claymore;
use Wallets;
use Auth;

class HomeController extends Controller
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
  * Show the application dashboard.
  *
  * @return \Illuminate\Http\Response
  */
  public function index()
  {
    $eth = new \IlyasDeckers\Web3PHP\Ethereum('127.0.0.1',8545);
    dd($eth->eth_getBalance());

    if (!Auth::user()->wallets->first()) {
      return view('auth.step2');
    }
    return view('dashboard');
  }
  
  public function step2() 
  {
    return view('auth.step2');
  }
  
}
