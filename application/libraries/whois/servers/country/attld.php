<?php namespace Whois\Servers\Country;

class Attld extends \Whois\Server
{
	protected $host = 'whois.nic.at';
	protected $surplus = array('0');
	protected $allow = array
	(
		'at', 'gv.at', 'ac.at', 'co.at', 'or.at', 'priv.at'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% nothing found/', $this->body);
	}

	public function updated_on()
	{
		if (preg_match('/changed:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}