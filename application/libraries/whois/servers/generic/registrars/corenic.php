<?php namespace Whois\Servers\Generic\Registrars;

class CoreNic extends \Whois\Server
{
	protected $host = 'whois.corenic.net';
	protected $surplus = array('0');
	protected $delimiter = "this policy.";

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
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