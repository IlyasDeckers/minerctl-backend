<?php 

namespace App\Acme\Wallets\Ethereum;

use App\Acme\Wallets\Ethereum\EthereumRequest;
use App\Acme\Wallets\Interfaces\WalletInterface;

class EthereumWallet implements WalletInterface
{
    private $request;

    /**
     * Instantiate request the object
     * 
     * @return none
     */
    public function __construct()
    {
        $this->request = new EthereumRequest;
    }

    /**
     * Get the account balance
     * 
     * @param string $walletAddress 
     * @return string
     */
    public function getBalance(String $walletAddress) 
    {   
        $r = $this->request;
        $r->setWalletAddress($walletAddress);
        $r->setModule('account');
        $r->setAction('balance');

        return $r->formatObjectValues(
            $r->sendRequest($r)->result
        );
    }

    /**
     * Get the account's transactions
     * 
     * @param string $walletAddress 
     * @return object
     */
    public function getTransactions(String $walletAddress)
    {
        $r = $this->request;
        $r->setWalletAddress($walletAddress);
        $r->setModule('account');
        $r->setAction('txlist');
        $r->setStartblock(0);
        $r->setEndblock(99999999);
        $r->setSort('dsc');
        return $r->formatObjectValues(
            $r->sendRequest($r)
        );
    }
}