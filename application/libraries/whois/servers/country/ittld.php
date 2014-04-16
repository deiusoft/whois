<?php namespace Whois\Servers\Country;

class Ittld extends \Whois\Server
{
	protected $host = 'whois.nic.it';
	protected $surplus = array('0');
	protected $allow = array('it', 'gov.it');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Status:[\s]+AVAILABLE/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expire Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Update:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}