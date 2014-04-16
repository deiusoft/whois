<?php

class Api_Controller extends Base_Controller
{
	public function action_query($domain)
	{
		$domain = strtolower($domain);
		$domain = trim($domain);
		$domain = trim($domain, '.');
		
		//remove protocol (http, https, ftp, etc)
		preg_match('/([^:]*:\/\/)?([^\/]+\.[^\/]+)/', $domain, $result);
		if (isset($result[2]))
			$domain = $result[2];

		Log::write('api', 'whois: '.$domain);

		$whois = new Whois\Whois($domain);
		$data = $whois->get_all_data();

		$result = array();

		if ($data === 0)
			$valid = 0;
		else
			$valid = $data[0]->valid();

		if (!$valid)
			$result[] = 'Invalid domain name...';
		else
		{
			foreach ($data as $server)
			{
				$result[$server->host()] = $server->get_body();

				if (is_int($result[$server->host()])) 
					$result[$server->host()] = 'Connection error...';
			}
		}

		$result = json_encode($result);  
		
		echo $result;
	}
}