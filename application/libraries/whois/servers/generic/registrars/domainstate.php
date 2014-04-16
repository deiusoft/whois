<?php namespace Whois\Servers\Generic\Registrars;

class DomainState extends \Whois\Server
{
	protected $host = 'whois.above.com';
	protected $surplus = array('-1');

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
		if (preg_match('/Creation date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		$section = explode('Domain Name:', $sections[0]);
		if (count($section) == 2)
			$sections[0] = 'Domain Name:'.$section[1];

		$section = explode('The data in', $sections[1]);
		if (count($section) == 2)
			$sections[1] = $section[0];

		return $sections;
	}
}