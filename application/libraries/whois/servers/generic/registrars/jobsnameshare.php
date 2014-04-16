<?php namespace Whois\Servers\Generic\Registrars;

class JobsNameshare extends \Whois\Server
{
	protected $host = 'whois-jobs.nameshare.com';

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Not found: '.$this->domain.'/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Domain Expiration Date[\s]+:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain Registration Date[\s]+:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Domain Last Updated Date[\s]+:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}