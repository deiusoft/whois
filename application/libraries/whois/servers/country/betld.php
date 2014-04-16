<?php namespace Whois\Servers\Country;

class Betld extends \Whois\Server
{
	protected $host = 'whois.dns.be';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array('be', 'ac.be');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Status:	AVAILABLE/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Registered:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}