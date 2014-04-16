<?php namespace Whois\Servers\Country;

class Sktld extends \Whois\Server
{
	protected $host = 'whois.sk-nic.sk';
	protected $surplus = array('0');
	protected $allow = array('sk');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Not found./', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Valid-date[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last-update[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}