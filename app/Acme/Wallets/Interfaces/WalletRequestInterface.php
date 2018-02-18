<?php
namespace App\Acme\Wallets\Interfaces;

interface WalletRequestInterface {

    public function sendRequest(Object $request);

	public function formatUrl(Object $EthereumRequest);

    public function formatObjectValues($response);
	
}