<?php

namespace App\Http\Controllers\Rigs;

use Auth;
use Claymore;
use Pusher;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RigController extends Controller
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
    public function index()
    {
        dd(Pusher::get_channels()); 

        $rigs = new Claymore;
        return view('rigs', [
            'rigs'       => $rigs->miner_getstat1()
        ]); 
    }
}