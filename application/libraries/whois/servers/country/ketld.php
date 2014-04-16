<?php namespace Whois\Servers\Country;

class Ketld extends \Whois\Server
{
	protected $host = 'whois.kenic.or.ke';
	protected $allow = array
	(
		'co.ke', 'or.ke', 'ne.ke', 'ac.ke', 'go.ke', 'sc.ke',
		'me.ke', 'mobi.ke', 'info.ke'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Status: Not Registered/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Modified:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}