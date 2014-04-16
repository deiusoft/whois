<?php namespace Whois\Servers\Country;

class Metld extends \Whois\Server
{
	protected $host = 'whois.nic.me';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'me', 'co.me', 'org.me', 'net.me', 'edu.me', 'gov.me',
		'ac.me', 'its.me', 'priv.me'
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
		if (preg_match('/Domain Expiration Date:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain Create Date:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Domain Last Updated Date:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}