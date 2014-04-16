<?php namespace Whois\Servers\Generic\Registrars;

class Godaddy extends \Whois\Server
{
	protected $port = 43;	
	protected $host = 'whois.godaddy.com';
	protected $surplus = array('0', '1', '2', 'last', '1');
	protected $delimiter = "\n\r";
	
	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function registrant()
	{
		if (preg_match('/Registrant:[\s]+(.*?)Administrative Contact:/s', $this->body, $match))
			return $match[1];

		return null;
	}

	public function nameservers()
	{
		if (preg_match('/Domain servers in listed order:[\s]+(.*)/s', $this->body, $match))
			return $match[1];

		return null;
	}

	public function expires_on()
	{
		if (preg_match('/Expires on:[\s]+(.*?)[\s]+/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created on:[\s]+(.*?)[\s]+/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated on:[\s]+(.*?)[\s]+/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function admin_contact()
	{
		if (preg_match('/Administrative Contact:[\s]+(.*?)Technical Contact:/s', $this->body, $match))
			return $match[1];

		return null;
	}

	public function tech_contact()
	{
		if (preg_match('/Technical Contact:[\s]+(.*?)Domain servers in listed order:/s', $this->body, $match))
			return $match[1];

		return null;
	}
}
