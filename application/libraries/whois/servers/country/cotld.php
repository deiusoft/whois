<?php namespace Whois\Servers\Country;

class Cotld extends \Whois\Server
{
	protected $host = 'whois.nic.co';
	protected $surplus = array('last', '1');
	protected $allow = array
	(
		'co', 'com.co', 'net.co', 'edu.co', 'org.co', 'gov.co',
		'mil.co', 'nom.co' 
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Not found: '.$this->domain.'/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Domain Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain Registration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Domain Last Updated Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}