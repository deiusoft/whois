<?php namespace Whois\Servers\Country;

class Fjtld extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.usp.ac.fj';
	protected $surplus = array('0');

	protected $allow = array
	(
		'ac.fj', 'biz.fj', 'com.fj', 'info.fj', 'mil.fj',
		'name.fj', 'net.fj', 'org.fj', 'pro.fj'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/The domain '.$this->domain.' was not found!/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		if (count($sections) === 2)
		{
			$sections[1] = explode("\n", trim($sections[1]));
			$sections[1] = $sections[1][0];
		}

		return $sections;
	}
}