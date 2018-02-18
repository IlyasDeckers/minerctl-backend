<?php
namespace App\Acme\Api;

class Claymore
{
	public function miner_getstat1()
	{
		$data = $this->strReplaceResponse(
			$this->miner_request(__FUNCTION__)
		);

		return $this->formatWorkerStats($data);
	}	
																	
	private function miner_request($method, $params=array())
	{
		$hosts = (object) [
			[
				'host' => '192.168.0.222',
				'port' => 3333
			]
		];

		$factory = new \Socket\Raw\Factory();

		$workers = [];
		foreach ($hosts as $host) {
			$socket = $factory->createClient($host['host'] . ':' . $host['port']);
			$socket->write('{"id":0,"jsonrpc":"2.0","method":"' . $method .'"}');
			$worker = $socket->read(8192);
			$socket->close();

			$workers[] = json_decode($worker);
		}

		return $workers;
	}

	private function formatWorkerStats($data)
	{
		$response = [];
		foreach ($data as $key => $value) {
			$res = new \stdClass;
			$res->gpu_stats = $this->getGpuStats($value);
			$res->pool = $value[7];

			$response[] = $res;
		}
		

		return $response;
	}

	private function strReplaceResponse($response)
	{
		$data = [];
		foreach ($response as $key => $value) {
			$data[$key] = str_replace(";",",",$value->result);
		}

		return $data;
	}

	private function getGpuStats($data)
	{
		$temps = array();
		$fans = array();
		foreach ($this->toArray($data[6])as $k => $v) {
		    if ($k % 2 == 0) {
		        $temps[] = $v;
		    } else {
		        $fans[] = $v;
		    }
		}

		$response = $this->setGpus($temps);
		$response = $this->setFanSpeed($fans, $response);
		$response = $this->setHashrate($data, $response);
		
		return $response;
	}

	private function gpuFormatResponse()
	{
		return (object) [
			'temp' 	=> '',
			'fan'	=> '',
			'hashrate' => ''
		];
	}

	private function setGpus($temps)
	{
		$n = 0;
		$response = new \stdclass;
		foreach ($temps as $temp) {
			$n++;
			$gpu = 'gpu' . $n;
			$response->$gpu = $this->gpuFormatResponse();
			$response->$gpu->temp = $temp;
		}

		return $response;
	}

	private function setFanSpeed($fans, $response)
	{
		$n = 0;
		foreach ($fans as $fan) {
			$n++;
			$gpu = 'gpu' . $n;
			$response->$gpu->fan = $fan;
		}

		return $response;
	}

	private function setHashrate($data, $response)
	{
		foreach ($data as $key => $value) {
			$n = 0;
			foreach ($this->toArray($data[3]) as $key => $hashrate) {
				$n++;
				$gpu = 'gpu' . $n;
				$response->$gpu->hashrate = $hashrate;
			}
		}

		return $response;
	}

	private function toArray($string)
	{
		return explode(",", $string);
	}
}