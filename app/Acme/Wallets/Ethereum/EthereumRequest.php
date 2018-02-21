<?php
namespace App\Acme\Wallets\Ethereum;

use Wallets;
use wei2eth;
use Countable;
use App\Acme\Wallets\Interfaces\WalletRequestInterface;

class EthereumRequest
{
	public $apiAddress = 'https://api.etherscan.io/api?';

	public $module;

	public $action;

	public $address;

	public $startBlock;

	public $endBlock;

	public $sort;

	public function __construct() 
	{
		//
	}
	
	public function setApiAddress($apiAddress)
	{
		$this->apiAddress = $apiAddress;
	}

	public function getApiAddress()
	{
		return $this->apiAddress;
	}

	public function setModule($module)
	{
		$this->module = $module;
	}

	public function getModule()
	{
		return $this->module;
	}

	public function setAction($action)
	{
		$this->action = $action;
	}

	public function getAction()
	{
		return $this->action;
	}

	public function setWalletAddress($walletAdress)
	{
		$this->address = $walletAdress;
	}

	public function getWalletAddress()
	{
		return $this->address;
	}

	public function setStartBlock($startBlock)
	{
		$this->startBlock = $startBlock;
	}

	public function getStartBlock()
	{
		return $this->startBlock;
	}

	public function setEndBlock($endBlock)
	{
		$this->endBlock = $endBlock;
	}

	public function getEndBlock()
	{
		return $this->endBlock;
	}

	public function setSort($sort)
	{
		$this->sort = $sort;
	}

	public function getSort()
	{
		return $this->EndBlock;
	}

	/**
     * Dispatch the api request
     * 
     * @param object $request 
     * @return object/string
     */
    public function sendRequest($request)
    {
        return Wallets::request(
        	$this->formatUrl($request)
       	); 
    }

	/**
	 * Format the api url to a string 
	 * 
	 * @param object $EthereumRequest 
	 * @return string
	 */
	public function formatUrl($EthereumRequest) 
	{
		$url = $this->apiAddress;
        foreach ($EthereumRequest as $k => $v) {
            if ($v != $url) {
                $url .= $k . '=' . $v . '&';
            }
        } 

        return $url;
    }

    /**
     * Format the responses to human readable formats
     *   - converts wei to eth
     * 
     * @param object/string $response 
     * @return object/string
     */
    public function formatObjectValues($response)
    {
    	if(isset($response->result)) {
	    	foreach($response->result as $x){
	            $x->value = wei2eth::convert($x->value);
	        }
	        return array_reverse($response->result);
	    }

	    return wei2eth::convert($response);
    }
}