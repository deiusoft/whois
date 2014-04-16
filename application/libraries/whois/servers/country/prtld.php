<?php namespace Whois\Servers\Country;

class Prtld extends \Whois\Server
{
	protected $host = 'whois.nic.pr';
	protected $surplus = array('0');
	protected $allow = array
	(
		'pr', 'com.pr', 'org.pr', 'net.pr', 'edu.pr', 'gov.pr',
		'info.pr', 'biz.pr', 'isla.pr', 'name.pr', 'pro.pr',
		'est.pr', 'prof.pr', 'ac.pr' 
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/The domain '.$this->domain.' is not registered./i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires On:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created On:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}