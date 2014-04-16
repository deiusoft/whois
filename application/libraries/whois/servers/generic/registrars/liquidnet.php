<?php namespace Whois\Servers\Generic\Registrars;

class LiquidNet extends \Whois\Server
{
	protected $host = 'whois.liquidnetlimited.com';
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
		if (preg_match('/Creation Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		$section = explode('The data in', $sections[count($sections) - 1]);
		if (count($section) == 2)
			$sections[count($sections) - 1] = $section[0];

		return $sections;
	}
}