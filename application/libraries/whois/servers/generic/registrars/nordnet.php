<?php namespace Whois\Servers\Generic\Registrars;

class NordNet extends \Whois\Server
{
	protected $host = 'whois.nordnet.net';
	protected $surplus = array('-1');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Record expires on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		$section = explode('Registrant:', $sections[0]);
		if (count($section) == 2)
			$sections[0] = 'Registrant:'.$section[1];

		$section = array_pop($sections);
		$section = explode('Deposez votre', $section);
		if (count($section) >= 2)
			$sections[] = $section[0];

		return $sections;
	}	
}