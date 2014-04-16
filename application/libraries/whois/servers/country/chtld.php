<?php namespace Whois\Servers\Country;

class Chtld extends \Whois\Server
{
	protected $host = 'whois.nic.ch';
	protected $allow = array('ch',);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/We do not have an entry in our database matching your query./', $this->body);
	}
}