<?php namespace Whois\Servers\Generic;

class Educase extends \Whois\Server
{
	protected $host = 'whois.educause.edu';
	protected $surplus = array('0', '1', '2', '3', '4', '5');
	protected $allow = array('edu');
	
	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No Match/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Domain expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain record activated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Domain record last updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}
