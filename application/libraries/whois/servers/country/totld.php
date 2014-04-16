<?php namespace Whois\Servers\Country;

class Totld extends \Whois\Server
{
	protected $host = 'whois.tonic.to';
	protected $surplus = array('0');
	protected $delimiter = "\n";
	protected $allow = array('to');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No match for /', $this->body);
	}
}