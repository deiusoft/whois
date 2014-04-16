<?php namespace Whois\Servers\Country;

class Aitld extends \Whois\Server
{
	protected $host = 'whois.ai';
	protected $allow = array
	(
		'ai', 'com.ai', 'net.ai', 'off.ai', 'org.ai',
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain '.$this->domain.' not registred./i', $this->body);
	}
}