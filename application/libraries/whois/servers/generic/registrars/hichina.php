<?php namespace Whois\Servers\Generic\Registrars;

class HiChina extends \Whois\Server
{
	protected $host = 'grs-whois.hichina.com';
	protected $surplus = array('last', '2');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date [\.]+ (.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}