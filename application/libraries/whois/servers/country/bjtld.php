<?php namespace Whois\Servers\Country;

class Bjtld extends \Whois\Server
{
	protected $host = 'whois.nic.bj';
	protected $allow = array
	(
		'bj', 'gouv.bj', 'mil.bj', 'edu.bj', 'asso.bj', 'gov.bj',
		'barreau.bj', 'com.bj'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No records matching '.$this->domain.' found./i', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}