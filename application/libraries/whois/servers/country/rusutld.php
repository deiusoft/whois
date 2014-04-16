<?php namespace Whois\Servers\Country;

class RuSutld extends \Whois\Server
{
	protected $host = 'whois.tcinet.ru';
	protected $surplus = array('0', 'last', '1');
	protected $allow = array('ru', 'su');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No entries found for the selected source/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/free-date:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('.', '-', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}

	public function created_on()
	{
		if (preg_match('/created:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('.', '-', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}
}