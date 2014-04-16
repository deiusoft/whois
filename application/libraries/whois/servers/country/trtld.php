<?php namespace Whois\Servers\Country;

class Trtld extends \Whois\Server
{
	protected $host = 'whois.nic.tr';
	protected $allow = array
	(
		'com.tr', 'gen.tr', 'org.tr', 'biz.tr', 'info.tr', 'av.tr',
		'dr.tr', 'bel.tr', 'tsk.tr', 'bbs.tr', 'k12.tr', 'edu.tr',
		'name.tr', 'net.tr', 'gov.tr', 'pol.tr', 'web.tr', 'tel.tr',
		'tv.tr', 'nc.tr'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No match found for /', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires on[\.]+: (.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created on[\.]+: (.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}