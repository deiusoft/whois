<?php namespace Whois\Servers\Generic\Registrars;

class NameVault extends \Whois\Server
{
	protected $host = 'whois.namevault.com';
	protected $surplus = array('0');

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
		if (preg_match('/Registration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		$section = array_pop($sections);

		$section = explode('The data in', $section);

		if (count($section) >= 2)
			$sections [] = $section[0];

		return $sections;
	}
}