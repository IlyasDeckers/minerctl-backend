<?php 

namespace App\Acme\Wallets;

use Auth;
use App\Wallet;
use GuzzleHttp\Client;
use App\Acme\Wallets\Ethereum\EthereumWallet;
use App\Acme\Wallets\EthereumClassic\EthereumClassicWallet;

class Wallets
{
    protected $wallet;

    protected $wallets;

    protected $walletAddress;

    protected $currency;

    public function __construct($walletAddress = null)
    {
        if (isset($walletAddress)) {
            $this->walletAddress = $walletAddress;
        }
    }

    public function request($apiRequest)
    {
        $client = new Client();

        return json_decode(
            $client->request('GET', $apiRequest)
                   ->getBody()
        ); 
    }

    public function getWallets()
    {
        $this->wallets = Auth::user()->wallets;

        return $this->wallets;
    }

    public function getWallet($walletAddress)
    {
        $this->getCurrency($walletAddress);

        return $this->formatWalletBalance(
            $this->wallet->getBalance($walletAddress),
            $this->getExchangeRates()
        );
    }

    public function getTransactions($walletAddress)
    {
        $this->getCurrency($walletAddress);

        return $this->wallet->getTransactions($walletAddress);
    }

    public function getCurrency($walletAddress, $return = false)
    {   
        try {
            $this->currency = Wallet::where('address', $walletAddress)
                ->first()
                ->currency;
        } catch (Exception $e) {
            dd($e);
        }

        if($return != false) {
            return $this->currency;
        }
        
        $this->selectWallet();
    }

    public function getExchangeRates()
    {
        return $this->request(
            'https://min-api.cryptocompare.com/data/price?fsym=' . strtoupper($this->currency) . '&tsyms=BTC,USD,EUR' 
        );
    }

    private function selectWallet()
    {   
        if ($this->currency == 'eth') {
            $this->wallet = new EthereumWallet;
        }

        if ($this->currency == 'etc') {
            $this->wallet = new EthereumClassicWallet;
        }
    }

    private function formatWalletBalance($balance, $exchangeRates)
    {
        return (object) [
            'value'     => $balance,
            'value_eur' => $this->convertCurrency($balance, $exchangeRates->EUR),
            'rate_eur'  => $exchangeRates->EUR,
            'value_usd' => $this->convertCurrency($balance, $exchangeRates->USD),
            'rate_usd'  => $exchangeRates->USD,
            'value_btc' => $this->convertCurrency($balance, $exchangeRates->USD),
            'rate_btc'  => $exchangeRates->BTC

        ];
    }

    public function convertCurrency($balance, $exchangeRate)
    {
        return $balance * $exchangeRate;
    }
}