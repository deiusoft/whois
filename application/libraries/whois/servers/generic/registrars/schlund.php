<?php namespace Whois\Servers\Generic\Registrars;

class Schlund extends \Whois\Server
{
	protected $host = 'whois.schlund.info';
	protected $surplus = array('-1');
	protected $delimiter = "\n\r";
	
	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/registration-expiration:[\s]+(.*?)\n/', $this->body, $match))
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
		if (preg_match('/last-changed:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		array_pop($sections);

		$section = explode('domain:', $sections[0]);
		if (count($section) == 2)
			$sections[0] = 'domain:'.$section[1];

		return $sections;
	}
}