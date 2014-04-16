<?php namespace Whois\Servers\Country;

class Motld extends \Whois\Server
{
	protected $host = 'whois.monic.mo';
	protected $surplus = array('0', '1');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'mo', 'com.mo', 'org.mo', 'net.mo', 'edu.mo', 'gov.mo',
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No match for \"'.$this->domain.'\"./i', $this->body);
	}
}