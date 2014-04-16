<?php namespace Whois\Servers\Country;

class Eutld extends \Whois\Server
{
	protected $host = 'whois.eu';
	protected $surplus = array('0');
	protected $delimiter = "\nDomain:";
	protected $allow = array('eu');

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
}