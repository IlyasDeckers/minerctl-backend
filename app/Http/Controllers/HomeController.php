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
    if (!Auth::user()->wallets->first()) {
      return view('auth.step2');
    }
    return view('dashboard', [
      'page_title' => 'Dashboard'
    ]);
  }
  
  public function step2() 
  {
    return view('auth.step2');
  }
  
}
