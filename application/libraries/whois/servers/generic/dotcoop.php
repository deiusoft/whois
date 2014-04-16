<?php namespace Whois\Servers\Generic;

class DotCoop extends \Whois\Server
{
	protected $host = 'whois.nic.coop';
	protected $surplus = array('0', '1', 'last', '4');
	protected $delimiter = "\n\r";
	protected $allow = array('coop');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}
	
	public function available()
	{
		return preg_match('/No domain records were found to match/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiry Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}
