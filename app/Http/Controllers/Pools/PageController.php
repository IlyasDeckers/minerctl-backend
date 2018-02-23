<?php

namespace App\Http\Controllers\Pools;

use Auth;
use App\Wallet;
use Wallets;
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
        $this->currency = Wallet::where('address', strtolower($walletAddress))->first()->currency;

        if ($this->currency == 'etc') {
            $this->url = 'https://api-etc.ethermine.org/miner/';
        }

        $this->address = $walletAddress;

        if ($request->ajax()) {
            return [$this->getEthermineStats()];
        }

        return view('pools', [
            'wallets' => Auth::user()->wallets,
            'chartjs' => $this->hashChart(),
            'wallet_balance'  => Wallets::getWallet($walletAddress)->value,
            'ethermine_stats' => $this->getEthermineStats(), 
            'payments' => $this->getPayments(),
            'currency' => $this->currency,
            'wallet_address' => $walletAddress
        ]); 
    }

    public function getPayments()
    {
        $payments = $this->request('payouts');

        foreach($payments as $payment) {
            $payment->amount = $this->wei2eth($payment->amount);
        }

        return $payments;
    }

    public function getEthermineStats()
    {
        $res = $this->request('currentStats');

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

    public function hashChart()
    {
        $averageHashrate = [];
        $currentHashrate = [];
        $reportedHashrate = [];
        $labels = [];
        foreach (array_slice($this->request('history'), -50, 50, true) as $d){
            $averageHashrate[] = $this->convertHashrate($d->averageHashrate);
            $currentHashrate[] = $this->convertHashrate($d->currentHashrate);
            $reportedHashrate[] = $this->convertHashrate($d->reportedHashrate);
            $labels[] = $d->time;
        }

        $chart = app()->chartjs
            ->name('lineChartTest')
            ->type('line')
            ->size(['width' => '100%', 'height' => '20%'])
            ->labels($labels)
            ->datasets([
                $this->chartData("Average Hashrate", $averageHashrate, "0, 188, 212"),
                $this->chartData("Current Hashrate", $currentHashrate, "244, 67, 54"),
                $this->chartData("reported Hashrate", $reportedHashrate, "255, 152, 0"),
            ])
            ->optionsRaw("{ 
                scales: {
                    yAxes: [{
                        display: true,
                        ticks: {
                            suggestedMin: 0,    // minimum will be 0, unless there is a lower value.
                            beginAtZero: true   // minimum value will be 0.
                        }
                    }]
                }
            }");

        return $chart;
    }

    public function chartData($label, $data, $color)
    {
        return [
            "label" => $label,
            'backgroundColor' => "rgba(" . $color . ", 0)",
            'borderColor' => "rgba(" . $color . ", 0.7)",
            "pointBorderColor" => "rgba(" . $color . ", 0, 0.7)",
            "pointBackgroundColor" => "rgba(" . $color . ", 0.7)",
            "pointHoverBackgroundColor" => "#fff",
            "pointHoverBorderColor" => "rgba(220,220,220,1)",
            'data' => $data,
        ];
    }

    public function getWalletBalance() 
    {   
        if ( $this->currency == 'etc' ) {
            $api = 'https://etcchain.com/api/v1/getAddressBalance?address=0x';
        } else {
            $api = 'https://api.etherscan.io/api?module=account&action=balance&address=';
        }

        $client = new Client();
        $res = $client->request('GET', $api . $this->address);
        $res = json_decode($res->getBody());

        if ( $this->currency == 'etc' ) {
            return $res->balance;
        }

        return $this->wei2eth($res->result);
    }

    /*
    * The following functions are for conversion
    * and for handling big numbers
    */
    function wei2eth($wei)
    {
        return bcdiv($wei,1000000000000000000,18);
    }

    function bchexdec($hex) 
    {
        if(strlen($hex) == 1) {
            return hexdec($hex);
        } else {
            $remain = substr($hex, 0, -1);
            $last = substr($hex, -1);
            return bcadd(bcmul(16, $this->bchexdec($remain)), hexdec($last));
        }
    }

    public function convertHashrate($hashrate)
    {
        return substr($hashrate / 1000000, 0, 5);
    }
}
