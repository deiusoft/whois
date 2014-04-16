<?php namespace Whois\Servers\Country;

class Tvtld extends \Whois\Server
{
	protected $host = 'tvwhois.verisign-grs.com';
	protected $surplus = array('0', '1', 'last', '4');
	protected $allow = array('tv');

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

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function next()
	{
		if (preg_match_all('/Whois Server: (.*?)\n/', $this->body, $refer))
			return end($refer[1]);
		
		return null;
	}
}