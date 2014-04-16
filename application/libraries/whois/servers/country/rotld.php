<?php namespace Whois\Servers\Country;

class Rotld extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.rotld.ro';
	protected $surplus = array('0', '1', '2', '3');
	protected $allow = array
	(
		'ro', 'arts.ro', 'com.ro', 'firm.ro', 'info.ro', 'nom.ro', 
		'nt.ro', 'org.ro', 'rec.ro', 'store.ro', 'tm.ro', 'www.ro'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/ No entries found for the selected source/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Registered On: Before[\s]+(.*?)\n/', $this->body, $match))
			return strtotime(trim($match[1]).'-01-01');

		if (preg_match('/Registered On:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}
}