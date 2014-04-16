<?php namespace Whois\Servers\Country;

class Smtld extends \Whois\Server
{
	protected $host = 'whois.nic.sm';
	protected $allow = array('sm');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No entries found./', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Registration date:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Update:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}
}