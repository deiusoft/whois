<?php namespace Whois\Servers\Generic;

class PuntCat extends \Whois\Server
{
	protected $host = 'whois.cat';
	protected $surplus = array('0');
	protected $delimiter = "this policy.";
	protected $allow = array('cat');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function next()
	{
		if (preg_match_all('/Whois Server: (.*?)[\s]+/', $this->body, $refer))
			return end($refer[1]);
		
		return null;
	}
	
	public function available()
	{
		return preg_match('/% Object \"'.$this->domain.'\" NOT FOUND\./i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created On:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated On:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}
