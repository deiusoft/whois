<?php namespace Whois\Servers\Country;

class GiScVctld extends \Whois\Server
{
	protected $host = 'whois2.afilias-grs.net';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'gi', 'com.gi', 'gov.gi', 'ltd.gi', 'mod.gi', 'edu.gi', 'org.gi',
		'sc', 'com.sc', 'net.sc', 'edu.sc', 'gov.sc', 'org.sc',
		'vc', 'com.vc', 'org.vc', 'net.vc'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created On:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated On:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}