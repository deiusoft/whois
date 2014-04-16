<?php namespace Whois\Servers\Generic\Registrars;

class Ename extends \Whois\Server
{
	protected $host = 'whois.ename.com';
	protected $delimiter = "\n\r";

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date :[\s]+(.*?)\n/', $this->body, $match))	
			return strtotime($match[1]);

		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registration Date :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}