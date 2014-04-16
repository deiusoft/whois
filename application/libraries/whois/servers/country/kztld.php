<?php namespace Whois\Servers\Country;

class Kztld extends \Whois\Server
{
	protected $host = 'whois.nic.kz';
	protected $surplus = array('0');
	protected $allow = array
	(
		'kz', 'com.kz', 'org.kz', 'net.kz', 'edu.kz', 'gov.kz',
		'mil.kz'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/\*\*\* Nothing found for this query./', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain created:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('(', '', $match[1]);
			$match[1] = str_replace(')', '', $match[1]);

			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last modified :[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('(', '', $match[1]);
			$match[1] = str_replace(')', '', $match[1]);

			return strtotime($match[1]);
		}

		return null;
	}
}