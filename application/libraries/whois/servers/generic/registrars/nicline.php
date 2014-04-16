<?php namespace Whois\Servers\Generic\Registrars;

class NicLine extends \Whois\Server
{
	protected $host = 'whois.nicline.com';
	protected $surplus = array('0');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Expires:[\s]+(.*?) [0-9]+:/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?) [0-9]+:/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last updated:[\s]+(.*?) [0-9]+:/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}