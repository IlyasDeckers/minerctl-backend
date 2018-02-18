<?php

namespace App\Http\Controllers;

use Claymore;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

use Wallets;

class HomeController extends Controller
{
    protected $address = '0x8fbb99e9e73cd62bb3adea5365ff0f9d90c9e532';

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
        return view('dashboard');
    }

}
