<?php 

namespace App\Acme\Pools;

use Auth;
use App\Wallet;
use GuzzleHttp\Client;
use App\Acme\Wallets\Ethereum\EthereumWallet;
use App\Acme\Wallets\EthereumClassic\EthereumClassicWallet;

class Ethermine
{
  protected $client;
  
  protected $address;
  
  protected $url = 'https://api.ethermine.org/miner/';
  
  public function request($function, $method = 'GET')
  {
    $this->client = new Client();
    if (Wallet::where('address', $this->address)->first()->currency === 'etc') {
      $this->url = 'https://api-etc.ethermine.org/miner/';
    }
    
    $res = json_decode($this->client
      ->request($method, $this->url . $this->address . '/' . $function)
      ->getBody()
    );
  
    return $res->data;
  }

  public function getPayments()
  {
    $payments = $this->request('payouts');
    
    foreach($payments as $payment) {
      $payment->amount = $this->wei2eth($payment->amount);
    }
    
    return $payments;
  }

  public function getEstimatedPayout($stats, $currency) 
  {
    if (!isset($stats->usdPerMin)) {
      $stats->usdPerMin = 0;
      $stats->coinsPerMin = 0;
    }

    $min_eur = $this->convertCurrency($stats->usdPerMin, 'USD', 'EUR');

    return (object) [
      'eur' => [
          'hour'  => round($min_eur * 60, 2) . ' EUR',
          'day'   => round($min_eur * 1440, 2) . ' EUR',
          'week'  => round($min_eur * 10080,2) . ' EUR',
          'month' => round($min_eur * 43829.0639, 2) . ' EUR'
      ],
      'eth' => [
          'hour'  => round($stats->coinsPerMin * 60, 5) . ' ' . strtoupper($currency),
          'day'   => round($stats->coinsPerMin * 1440, 5) . ' ' . strtoupper($currency),
          'week'  => round($stats->coinsPerMin * 10080, 5) . ' ' . strtoupper($currency),
          'month' => round($stats->coinsPerMin * 43829.0639, 5) . ' ' . strtoupper($currency)
      ],
      'usd' => [
          'hour'  => round($stats->usdPerMin * 60, 2) . ' USD',
          'day'   => round($stats->usdPerMin * 1440, 2) . ' USD',
          'week'  => round($stats->usdPerMin * 10080, 2) . ' USD',
          'month' => round($stats->usdPerMin * 43829.0639, 2) . ' USD'
      ]
    ];
  }

  public function getlastStatisticss($walletAddress)
  {
    $this->address = $walletAddress;
    $res = $this->request('currentStats');
    
    if ($res == [] || $res == 'NO DATA') {
      $res = (object) [];
      $res->currentHashrate = 0;
      $res->averageHashrate = 0;
      $res->reportedHashrate = 0;
      $res->activeWorkers = 0;
      $res->unpaid = 0;
    }

    if(!isset($res->validShares)) {
      $res->validShares = 0;
    }
  
    $res->unpaid = $this->wei2eth($res->unpaid);
    
    $res->currentHashrate = $this->convertHashrate($res->currentHashrate);
    $res->averageHashrate = $this->convertHashrate($res->averageHashrate);
    $res->reportedHashrate = $this->convertHashrate($res->reportedHashrate);
    
    return $res;
  }

  public function chart($walletAddress) 
  {
    $this->address = $walletAddress;
    $averageHashrate = [];
    $currentHashrate = [];
    $reportedHashrate = [];
    $labels = [];
    foreach (array_slice($this->request('history'), -50, 50, true) as $d){
      $averageHashrate[] = $this->convertHashrate($d->averageHashrate);
      $currentHashrate[] = $this->convertHashrate($d->currentHashrate);
      $reportedHashrate[] = $this->convertHashrate($d->reportedHashrate);
      $labels[] = \Carbon\Carbon::createFromTimestamp($d->time)->format('H:i');
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
  
  private function convertHashrate($hashrate)
  {
    return substr($hashrate / 1000000, 0, 5);
  }
  
  private function convertCurrency($amount, $from, $to){
    $conv_id = "{$from}_{$to}";
    $string = file_get_contents("http://free.currencyconverterapi.com/api/v3/convert?q=" . $conv_id . "&compact=ultra");
    $json_a = json_decode($string, true);
    
    return $amount * round($json_a[$conv_id], 4);
  }
}
