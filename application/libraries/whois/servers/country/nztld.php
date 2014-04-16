<?php namespace Whois\Servers\Country;

class Nztld extends \Whois\Server
{
	protected $host = 'whois.srs.net.nz';
	protected $surplus = array('0', '1', '2', 'last', '15');
	protected $delimiter = "%";
	protected $allow = array
	(
		'ac.nz', 'co.nz', 'geek.nz', 'gen.nz', 'kiwi.nz', 'maori.nz',
		'net.nz', 'org.nz', 'school.nz', 'cri.nz', 'govt.nz', 'iwi.nz',
		'parliament.nz', 'mil.nz', 'health.nz'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/query_status: 220 Available/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/domain_datebilleduntil:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/domain_dateregistered:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/domain_datelastmodified:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}