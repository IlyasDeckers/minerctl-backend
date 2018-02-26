<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\MinerStatistics;
use Carbon\Carbon;
use Ethermine;
use Claymore;
use Wallets;
use Auth;

use Redirect;
use Alert;

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

    $wallet = Auth::user()->wallets->first();
    $walletAddress = $wallet->address;

    $m = \App\MinerStatistics::where('user_id', auth()->user()->id)
                ->where('created_at','>=', Carbon::now()->subMinutes('2'))
                ->get()
                ->groupBy('rigname');

    $miners = [];
    foreach($m as $miner) {
      $miner = $miner->first();
      $miner->data = json_decode($miner->data);
      $miners[] = $miner;
    }

    $ethermine = new Ethermine($walletAddress);

    return view('dashboard', [
      'page_title'         => 'Dashboard',
      'miners'             => $miners,
      'notifications_dash' => Auth::user()->notifications->take(10),
      'total_stats'        => Ethermine::getlastStatisticss($walletAddress),
      'wallet'             => Wallets::getWallet($walletAddress)
    ]);
  }
  
  public function step2() 
  {
    return view('auth.step2');
  }

  public function getEthermineStats()
  {
    
    
    if ($res == [] || $res == 'NO DATA') {
        $res = (object) [];
        $res->currentHashrate = 0;
        $res->averageHashrate = 0;
        $res->reportedHashrate = 0;
        $res->activeWorkers = 0;
        $res->unpaid = 0;
    }

    $res->unpaid = $this->wei2eth($res->unpaid);

    $res->currentHashrate = $this->convertHashrate($res->currentHashrate);
    $res->averageHashrate = $this->convertHashrate($res->averageHashrate);
    $res->reportedHashrate = $this->convertHashrate($res->reportedHashrate);

    return $res;
  }
  
}
