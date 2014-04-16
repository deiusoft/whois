<?php namespace Whois\Servers\Country;

class Jetld extends \Whois\Server
{
	protected $host = 'whois.je';
	protected $surplus = array('0');
	protected $allow = array
	(
		'je', 'co.je', 'org.je', 'net.je'
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