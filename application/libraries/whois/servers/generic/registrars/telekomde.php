<?php namespace Whois\Servers\Generic\Registrars;

class TelekomDe extends \Whois\Server
{
	protected $host = 'whois.registrar.telekom.de';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/changed:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}