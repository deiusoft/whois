<?php namespace Whois\Servers\Country;

class Ugtld extends \Whois\Server
{
	protected $host = 'whois.co.ug';
	protected $surplus = array('0');
	protected $allow = array
	(
		'ug', 'com.ug', 'org.ug', 'ne.ug', 'ac.ug', 'go.ug',
		'co.ug', 'sc.ug', 'or.ug'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No entries found for the selected source/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiry:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registered:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}
		
		return null;
	}
}