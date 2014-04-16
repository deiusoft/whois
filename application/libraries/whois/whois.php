<?php namespace Whois;

class Whois
{
	public function __construct($domain, $disclaimer = false)
	{
		$this->result = $this->query($domain, $disclaimer);
	}

	public function __call($method, $args)
	{
		foreach ($this->result as $server)
		{
			if (method_exists($server, $method))
			{
				return call_user_func_array(array($server, $method), $args);
			}
		}
	}

	public function config_get($key = 'map')
	{
		$config = include('config.php');

		if (!isset($config[$key])) 
			return null;

		return $config[$key];
	}

	/**
	* @return 	array
	*			0 -> invalid domain name
	*			$server	(body = 1) -> socket connection error
	*			$server (body = 2) -> curl connection error
	*			$server (body = 3) -> empty response
	*/
	public function query($domain, $disclaimer)
	{
		//validate format and chars
		if
		(
			!preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $domain)
			&&  
			!filter_var($domain, FILTER_VALIDATE_IP)
		)
			return 0;

		//query
		$result = array();
		$curl = false;
		$next = 'whois.iana.org';
		$map = $this->config_get('map');

		$server = 'Whois\Servers\Iana';
		$server = new $server($domain);
		if ($server->get_query_string() === null)
			return 0;

		$res = $server->body($disclaimer);
		$next = $server->next();
		
		if (!$next)
		{
			$next = $server->curl_next();
			$curl = true;
		}

		if ($res)
			$result[] = $server;

		while ($next)
		{
			if (array_key_exists($next, $map))
			{
				$domain = $server->get_query_domain();
				$server = 'Whois\Servers\\'.$map[$next];
				$server = new $server($domain);
				if ($server->get_query_string() === null)
					return 0;

				$res = $server->body($disclaimer);
				$next = $server->next();

				if (!$next)
				{
					$next = $server->curl_next();
					$curl = true;
				}

				if ($res)
					$result[] = $server;
			}
			else if ($curl === false)
			{
				$domain = $server->get_query_domain();
				$server = new Server($domain);
				$server->host($next);

				\Log::write('unparsed', 'whois: '.$server->host().' -> '.$domain);
				if ($server->get_query_string() === null)
					return 0;

				$res = $server->body($disclaimer);
				$next = $server->next();

				if ($res)
					$result[] = $server;
			}
			else
			{
				\Log::write('unparsed', 'whois-curl: '.$next.' -> '.$domain);
				$next = null;
			}
		}

		return $result;
	}

	public function get_raw_data()
	{
		return end($this->result)->body();
	}

	public function get_all_data()
	{
		return $this->result;
	}

	public function email_mask($data = '')
	{
		if (!$data)	$data = $this;

		$new_result = array();

		foreach ($data as $server)
		{
			$body = preg_replace_callback
			(
				'/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,6}/i' ,
				create_function
				(
					'$matches',
					'$image_code = \\Email::email_to_img($matches[0]);
					return "<img src=\'data:im/png;base64,".$image_code."\' />";'
				),
				$server->get_body()
			);
			
			if ($body)
				$server->get_body($body);
			
			$new_result[] = $server;
		}

		return $new_result;
	}
}
