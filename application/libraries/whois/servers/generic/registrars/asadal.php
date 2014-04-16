<?php namespace Whois\Servers\Generic\Registrars;

class Asadal extends \Whois\Server
{
	protected $host = 'whois.asadal.com';
	protected $surplus = array('0', 'last', '1');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date[\s]+:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('. ', '-', $match[1]);
			$match[1] = trim($match[1], '-');

			return strtotime($match[1]);
		}
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registered Date[\s]+:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('. ', '-', $match[1]);
			$match[1] = trim($match[1], '-');

			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated Date[\s]+:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('. ', '-', $match[1]);
			$match[1] = trim($match[1], '-');
			
			return strtotime($match[1]);
		}
		
		return null;
	}
}