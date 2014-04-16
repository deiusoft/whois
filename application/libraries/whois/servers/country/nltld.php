<?php namespace Whois\Servers\Country;

class Nltld extends \Whois\Server
{
	protected $host = 'whois.domain-registry.nl';
	protected $surplus = array('last', '2');
	protected $delimiter = "\n\r";
	protected $allow = array('nl');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/'.$this->domain.' is free/i', $this->body);
	}
}