<?php 

namespace App\Acme\Wallets\EthereumClassic;

use Wallets;
use Illuminate\Http\Request;

class EthereumClassicWallet extends Wallets
{
    public function getBalance($walletAddress) 
    {   
        return Wallets::request('https://etcchain.com/api/v1/getAddressBalance?address=' . $walletAddress)->balance;
    }

    public function getTransactions($walletAddress)
    {
	    $api = 'https://etcchain.com/api/v1/getTransactionsByAddress?address=' . $walletAddress;
	    $res = Wallets::request($api);

	    foreach($res as $x){
            $x->value = $x->valueEther;
        }

	    return array_reverse($res);
    }
}
