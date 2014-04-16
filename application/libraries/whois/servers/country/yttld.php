<?php namespace Whois\Servers\Country;

class Yttld extends \Whois\Server
{
	protected $host = 'whois.nic.yt';
	protected $surplus = array('0');
	protected $allow = array('yt');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/%% No entries found in the AFNIC Database./', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/created:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/last-update:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}
		
		return null;
	}
}