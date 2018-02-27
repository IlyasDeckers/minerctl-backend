<?php

namespace App\Http\Controllers\Rigs;

use Rigs;
use Auth;
use Carbon\Carbon;
use App\MinerStatistics;
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
     * Show the rigs dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rigs', [
            'page_title' => 'Mining Rigs',
            'rigs' => Rigs::getLastStatistics(),
            'chart' => Rigs::chart(120)
        ]);
    }
}
