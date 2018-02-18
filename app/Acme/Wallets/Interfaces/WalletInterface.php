<?php
namespace App\Acme\Wallets\Interfaces;

interface WalletInterface {

	public function getBalance(String $walletAddress);

	public function getTransactions(String $walletAddress);
	
}