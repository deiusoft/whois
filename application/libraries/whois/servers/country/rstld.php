<?php namespace Whois\Servers\Country;

class Rstld extends \Whois\Server
{
	protected $host = 'whois.rnids.rs';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'rs', 'co.rs', 'org.rs', 'edu.rs', 'gov.rs',
		'in.rs', 'ac.rs'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/%ERROR:103: Domain is not registered/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registration date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Modification date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}