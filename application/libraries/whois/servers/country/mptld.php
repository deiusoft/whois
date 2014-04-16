<?php namespace Whois\Servers\Country;

class Mptld extends \Whois\Server
{
	protected $host = 'whois.nic.mp';
	protected $allow = array('mp');

	public function __construct($domain)
	{
		$this->domain = $domain;
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}
}