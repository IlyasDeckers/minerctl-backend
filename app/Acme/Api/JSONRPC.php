<?php
namespace App\Acme\Api;

use GuzzleHttp\Client;

class JSONRPC
{
	protected $host, $port, $version;
	protected $id = 0;
	
	function __construct($host, $port, $version="2.0")
	{
		$this->host = $host;
		$this->port = $port;
		$this->version = $version;
	}
	
	function request($method, $params=array())
	{
		$data = json_encode([
			'jsonrpc' 	=> $this->version, 
			'id'		=> $this->id, 
			'method' 	=> $method, 
			'params' 	=> array_values($params)
		]);

		$data = [
			'body' => $data, 
			'headers' 	=> [
				'Content-Type' => 'application/json',
		    ]
		];

		$client = new Client();
		$response = $client->request(
			'POST', 
			$this->host . ':' . $this->port, 
			$data
		)->getBody()->getContents();

		/*$response = json_decode($response, true);*/

		dd($response);

        if (json_last_error() > 0) {
            throw new \Exception(json_last_error_msg());
        }

        if ($response['id'] !== $this->id) {
            throw new \Exception(
                sprintf('Given ID %d, differs from expected %d', $response['id'], $this->id)
            );
        } elseif (!empty($response['error'])) {
            throw new \Exception(
                sprintf('Error: ', json_encode($response))
            );
        }

        return $response['result'];

		return $client;

		/*$data = array();
		$data['jsonrpc'] = $this->version;
		$data['id'] = $this->id++;
		$data['method'] = $method;
		$data['params'] = $params;
		
		$ch = curl_init();
		
		curl_setopt($ch, CURLOPT_URL, $this->host);
		curl_setopt($ch, CURLOPT_PORT, $this->port);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		
		$ret = curl_exec($ch);*/
		
		if($ret !== FALSE)
		{
			$formatted = $this->format_response($ret);
			
			if(isset($formatted->error))
			{
				throw new RPCException($formatted->error->message, $formatted->error->code);
			}
			else
			{
				return $formatted;
			}
		}
		else
		{
			throw new RPCException("Server did not respond");
		}
	}
	
	function format_response($response)
	{
		return @json_decode($response);
	}
}

class RPCException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString() 
    {
        return __CLASS__ . ": ".(($this->code > 0)?"[{$this->code}]:":"")." {$this->message}\n";
    }
}