<?php namespace Whois\Servers\Country;

class Lktld extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.nic.lk';
	protected $surplus = array('-1');
	protected $allow = array
	(
		'lk', 'gov.lk', 'sch.lk', 'net.lk', 'int.lk', 'com.lk',
		'org.lk', 'edu.lk', 'ngo.lk', 'soc.lk', 'web.lk',
		'ltd.lk', 'assn.lk', 'grp.lk', 'hotel.lk'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/This Domain is not available in our whois database/', $this->body);
	}

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

		if (!$data)
		{
			if (count(explode('.', $this->domain)) >= 3)
				$data = 'This Domain is not available in our whois database';
			else
				$data = 3;
		}

		if (!is_int($data))
			$this->body = $data."\n";
		else
			$this->body = $data;

		if (!$disclaimer || $this->connection_type === 'curl')
			$this->remove_surplus(); 

		return $this->body;
	}

	public function expires_on()
	{
		if (preg_match('/Expires on[\.]+:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created on[\.]+:(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('before ', '', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated on[\.]+:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		if (preg_match('/Visit LK Domain at www.nic.lk/', $sections[0]))
			array_shift($sections);

		return $sections;
	}
}