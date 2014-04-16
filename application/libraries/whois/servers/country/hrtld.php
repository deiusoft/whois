<?php namespace Whois\Servers\Country;

class Hrtld extends \Whois\Server
{
	protected $host = 'whois.dns.hr';
	protected $allow = array
	(
		'hr', 'com.hr', 'from.hr', 'iz.hr'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/%ERROR: no entries found/', $this->body);
	}
}