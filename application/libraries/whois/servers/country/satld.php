<?php namespace Whois\Servers\Country;

class Satld extends \Whois\Server
{
	protected $host = 'whois.nic.net.sa';
	protected $surplus = array('0');
	protected $allow = array
	(
		'sa', 'com.sa', 'org.sa', 'net.sa', 'edu.sa', 'gov.sa',
		'sch.sa', 'med.sa', 'pub.sa'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No Match for '.$this->domain.'/i', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Created on:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated on:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}