<?php namespace Whois\Servers\Generic;

class Arin extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.arin.net';
	protected $surplus = array('0', 'last', '1');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		$this->query_string = 'n '.$this->domain;
	}
}
