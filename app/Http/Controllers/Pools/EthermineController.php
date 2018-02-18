<?php

namespace App\Http\Controllers\Pools;

use Redirect;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EthermineController extends Controller
{
    protected $client;

    protected $address;

    protected $url = 'https://api.ethermine.org/miner/';

    public function __construct()
    {
        $this->middleware('auth');
        $this->client = new Client();
    }

    public function request($function, $method = 'GET')
    {
        $this->client = new Client();

        $res = json_decode($this->client
            ->request($method, $this->url . $this->address . '/' . $function)
            ->getBody()
        );

        return $res->data;
    }
}
