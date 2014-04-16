<?php namespace Whois\Servers\Country;

class Catld extends \Whois\Server
{
	protected $host = 'whois.cira.ca';
	protected $surplus = array('last', '1');
	protected $allow = array('ca');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain status:[\s]+available/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiry date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}