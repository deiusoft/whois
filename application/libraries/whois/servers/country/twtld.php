<?php namespace Whois\Servers\Country;

class Twtld extends \Whois\Server
{
	protected $host = 'whois.twnic.net.tw';
	protected $surplus = array('last', '1');
	protected $allow = array
	(
		'tw', 'com.tw', 'org.tw', 'net.tw', 'edu.tw', 'gov.tw',
		'mil.tw', 'idv.tw', 'game.tw', 'ebiz.tw', 'club.tw'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No Found/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Record expires on[\s]+(.*?) /', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created on[\s]+(.*?) /', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}