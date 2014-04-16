<?php namespace Whois\Servers\Country;

class Bntld extends \Whois\Server
{
	protected $host = 'whois.bn';
	protected $surplus = array('0', 'last', '1');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'bn', 'com.bn', 'net.bn', 'edu.bn', 'org.bn', 'gov.bn'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No records matching '.$this->domain.' found./i', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}