<?php namespace Whois\Servers\Generic;

class Crsnic extends \Whois\Server
	protected $port = 43;
	protected $host = 'whois.crsnic.net';

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}
	
	public function next()
	{
		if (preg_match('/Whois Server: (.*?)[\s]+/', $this->body, $refer))
			return $refer[1];
		
		return null;
	}

	public function available()
	{
		return preg_match('/No match for \"'.$this->domain.'\"./i', $this->body);
	}
}
