<?php namespace Whois\Servers\Country;

class Ustld extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.nic.us';
	protected $surplus = array('last', '4');
	protected $allow = array('us');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Not found: '.$this->domain.'[\s]+/i', $this->body);
	}

	public function registrant()
	{
		if (preg_match('/Registrant ID:[\s]+(.*?)Administrative Contact ID:/s', $this->body, $match))
			return $match[1];

		return null;
	}

	public function registrar_info()
	{
		if (preg_match('/Sponsoring Registrar:[\s]+(.*?)Domain Status: /is', $this->body, $match))
		{
			return $match[1];
		}

		return null;
	}

	public function nameservers()
	{
		if (preg_match_all('/Name Server:[\s]+(.*?)[\s]+/', $this->body, $pieces))
			return implode("\n", $pieces[1]);
		
		return null;
	}

	public function expires_on()
	{
		if (preg_match('/Domain Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain Registration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Domain Last Updated Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function admin_contact()
	{
		if (preg_match('/Administrative Contact ID:[\s]+(.*?)Billing Contact ID:/s', $this->body, $match))
			return $match[1];

		return null;
	}

	public function tech_contact()
	{
		if (preg_match('/Technical Contact ID:[\s]+(.*?)Name Server: /s', $this->body, $match))
			return $match[1];

		return null;
	}
}