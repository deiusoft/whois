<?php namespace Whois\Servers\Generic\Registrars;

class Ascio extends \Whois\Server
{
	protected $host = 'whois.ascio.com';
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
		if (preg_match('/Record expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		$section = $sections[1];
		$section = explode('AVAILABILITY OF A DOMAIN NAME.', $section);
		
		if (count($section) == 2)
			$sections[1] = $section[1];

		return $sections;
	}
}