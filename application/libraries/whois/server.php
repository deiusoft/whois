<?php namespace Whois;

class Server
{
	protected $port = 43;
	protected $body = '';
	protected $host = 'whois.iana.org';
	protected $allow = array();
	protected $attempts = 3;
	protected $surplus = array();
	protected $delimiter = "\n\n";
	protected $curl_link = '';
	protected $curl_post = false;
	protected $curl_post_fields = array();
	protected $connection_type = 'socket';

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string)) {
			$this->query_string = $this->domain;
		}	
	}

	public function host($host = '')
	{
		if ($host)	$this->host = $host;

		return $this->host;
	}

	public function port($port = 43)
	{
		$this->port = $port;

		return $this->port;
	}

	public function curl_link($link = '')
	{
		if ($link)	$this->curl_link = $link;
		
		return $this->curl_link;
	}

	public function curl_post_fields($fields = array())
	{
		if (!empty($fields))	$this->curl_post_fields = $fields;
		
		return $this->curl_post_fields;
	}

	public function connection_type($type = '')
	{
		if ($type)	$this->connection_type = $type;
		
		return $this->connection_type;
	}

	public function attempts($dec = 0)
	{
		$this->attempts = $this->attempts - $dec;

		return $this->attempts;
	}

	public function next()
	{
		return null;
	}

	public function curl_next()
	{
		return null;
	}

	public function config_curl($link)
	{
		$this->curl_link($link);

		if ($this->query_string && $this->curl_post)
		{
			$fields = $this->generate_curl_post_fields();	
			$this->curl_post_fields($fields);
		}
	}

	public function generate_curl_post_fields()
	{
		return array();
	}

	public function domain_explode()
	{
		$ok = false;
		$tld = explode('.', $this->domain);

		array_shift($tld);
		while (!empty($tld) && !$ok)
		{
			if (in_array(implode('.', $tld), $this->allow))
			{
				$tld = implode('.', $tld);
				$ok = true;
			}
			else
			{
				array_shift($tld);
			}
		}

		$domain = explode('.'.$tld, $this->domain);
		$domain = $domain[0];

		return array('tld' => $tld, 'domain' => $domain);
	}

	/**
	* @return 	string
	*			1 -> socket connection error
	*			2 -> curl connection error
	*/
	public function body($disclaimer = false)
	{
		$data = '';	$ok = false;
		while (!$ok && $this->attempts() > 0)
		{
			$data = $this->execute_query();
			if (!is_int($data))
				$ok = true;
		}

		if (!$ok)
			\Log::write('error', 'connexion: '.$this->host().' -> '.$this->get_query_string());

		if (!$data)	$data = 3;
		
		if (!is_int($data))
			$this->body = $data."\n";
		else
			$this->body = $data;

		if (!$disclaimer || $this->connection_type === 'curl')
			$this->remove_surplus(); 

		return $this->body;
	}

	/**
	* @return array
	*/
	public function auxiliary_remove($sections)
	{
		if (in_array('last', $this->surplus))
		{
			$last = array_pop($this->surplus);
					array_pop($this->surplus);
			
			for ($i = 1; $i <= $last; $i++) 
				array_pop($sections);
		}

		return $sections;
	}

	public function remove_surplus()
	{
		if (count($this->surplus))
		{
			$sections = explode($this->delimiter, $this->body);
			if (count($sections) > 1)
			{
				$sections = $this->auxiliary_remove($sections);
				$body = '';

				foreach ($sections as $key => $value)
				{
					if (!in_array($key, $this->surplus))
						$body .= "\n\n".$value;
				}

				$body = trim($body);
				$this->body = $body."\n";
			}
		}
	}
	
	public function refresh()
	{
		\Cache::forget(get_class($this).'.'.$this->domain);
	}

	public function get_query_string()
	{
		return $this->query_string;
	}

	public function get_query_domain()
	{
		return $this->domain;
	}

	/**
	* @return 	string
	*			1 -> socket connection error
	*			2 -> curl connection error
	*/
	public function execute_query()
	{
		$this->attempts(1);
		if ($this->connection_type === 'socket') 
		{
			$fp = @fsockopen($this->host(), $this->port(), $errno, $errstr, 3);
					
			if ($fp === false)
				return 1;
			else
			{
				$data = '';
				fwrite($fp, "$this->query_string\r\n");
				while(!feof($fp))
					$data .= fgets($fp, 1024);

				fclose($fp);
				return trim($data);
			}
		}

		if ($this->connection_type === 'curl') 
		{
			$ch = curl_init($this->curl_link);

			if ($ch === false)
				return 2;
			else
			{
				$user_agent	=	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 '
								. '(KHTML, like Gecko) Chrome/22.0.1207.1 Safari/537.1';

				if ($this->curl_post)
				{
					$fields = $this->curl_post_fields;
					$fields_string = '';

					foreach ($fields as $key => $value)
						$fields_string .= $key.'='.urlencode($value).'&';
						
					rtrim($fields_string, '&');

					curl_setopt($ch,CURLOPT_POST, count($fields));
					curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
				}

				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 3);

				$data = curl_exec($ch);
				curl_close($ch);

				if ($data === false)
					return 2;
				else
					return trim(strip_tags($data));
			}
		}
	}

	public function get_domain($domain)
	{
		if (filter_var($domain, FILTER_VALIDATE_IP)) 
			return $domain;

		if (get_class($this) !== 'Server')
		{		
			// sort tlds by length
			usort($this->allow, function($a, $b)
			{
				return strlen($b) - strlen($a);
			});
			$pattern = implode('|', $this->allow);

			// escape . (dot all)
			str_replace('.', '\.', $pattern);

			$pattern = '/[^\.]+\.(?:'.$pattern.')$/';

			if (!empty($this->allow))
			{
				if (preg_match($pattern, $domain, $result))
					return $result[0];
				else
					return null;
			}

			$parts = explode('.', $domain);
			$n = count($parts);
			
			$this->query_string = $parts[$n-2].'.'.$parts[$n-1];

			return $domain;
		}

		$parts = explode('.', $domain);
		$n = count($parts);
		
		return $parts[$n-2].'.'.$parts[$n-1];
	}

	public function get_body($value = '')
	{
		if ($value)
			$this->body = $value;
		
		return $this->body;
	}
}
