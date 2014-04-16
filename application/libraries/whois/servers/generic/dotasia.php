<?php namespace Whois\Servers\Generic;

class DotAsia extends \Whois\Server
{
	protected $host = 'whois.nic.asia';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array('asia');

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
