<?php namespace Whois\Servers\Country;

class Sitld extends \Whois\Server
{
	protected $host = 'whois.arnes.si';
	protected $surplus = array('0');
	protected $allow = array('si');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No entries found for the selected source/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/expire:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		if (count($sections) > 2)
			array_pop($sections);

		return $sections;
	}
}