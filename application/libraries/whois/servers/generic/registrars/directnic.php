<?php namespace Whois\Servers\Generic\Registrars;

class DirectNic extends \Whois\Server
{
	protected $host = 'whois.directnic.com';

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
		if (preg_match('/Record last updated[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		array_pop($sections);

		$section = explode('Registrant:', $sections[0]);
		if (count($section) == 2)
			$sections[0] = 'Registrant:'.$section[1];

		return $sections;
	}
}