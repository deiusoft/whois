<?php namespace Whois\Servers\Country;

class Shtld extends \Whois\Server
{
	protected $host = 'whois.nic.sh';
	protected $surplus = array('1');
	protected $delimiter = "\n";
	protected $allow = array('sh');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain \"'.$this->domain.'\" - Available/i', $this->body);
	}
}