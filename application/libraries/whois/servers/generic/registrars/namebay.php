<?php namespace Whois\Servers\Generic\Registrars;

class Namebay extends \Whois\Server
{
	protected $host = 'whois.namebay.com';

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created On :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function remove_surplus($delimiter)
	{
		$body = preg_replace('/^.+\n/', '', $this->body);

		if ($body) 
			$this->body = $body."\n";
	}
}