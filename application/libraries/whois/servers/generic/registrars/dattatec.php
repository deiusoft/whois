<?php namespace Whois\Servers\Generic\Registrars;

class DattaTec extends \Whois\Server
{
	protected $host = 'whois.dattatec.com';
	protected $surplus = array('last', '2');

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
}