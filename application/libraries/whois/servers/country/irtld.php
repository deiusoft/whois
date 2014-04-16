<?php namespace Whois\Servers\Country;

class Irtld extends \Whois\Server
{
	protected $host = 'whois.nic.ir';
	protected $surplus = array('0', '1', '2');
	protected $allow = array
	(
		'ir', 'co.ir', 'org.ir', 'net.ir', 'sch.ir', 'gov.ir',
		'ac.ir', 'id.ir'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/%ERROR:101: no entries found/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/expire-date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/last-updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}