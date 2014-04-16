<?php namespace Whois\Servers\Country;

class Wstld extends \Whois\Server
{
	protected $host = 'whois.website.ws';
	protected $surplus = array('0', '1');
	protected $allow = array
	(
		'ws', 'com.ws', 'org.ws', 'net.ws', 'edu.ws', 'gov.ws',
		'info.ws', 'biz.ws', 'mob.ws', 'tel.ws'
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

	public function expires_on()
	{
		if (preg_match('/Domain Currently Expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Domain Last Updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}