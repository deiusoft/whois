<?php namespace Whois\Servers\Country;

class Ggtld extends \Whois\Server
{
	protected $host = 'whois.gg';
	protected $surplus = array('0');
	protected $allow = array
	(
		'gg', 'co.gg', 'net.gg', 'org.gg'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Status: Not Registered/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}