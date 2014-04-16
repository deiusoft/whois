<?php namespace Whois\Servers\Country;

class Lttld extends \Whois\Server
{
	protected $host = 'whois.domreg.lt';
	protected $allow = array('lt');
	protected $surplus = array('0');
	protected $delimiter = "\nDomain:";
	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Status:[\s]+available/', $this->body);
	}
}