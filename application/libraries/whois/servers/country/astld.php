<?php namespace Whois\Servers\Country;

class Astld extends \Whois\Server
{
	protected $host = 'whois.nic.as';
	protected $surplus = array('0', 'last', '1');
	protected $allow = array('as');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain Not Found/', $this->body);
	}
}