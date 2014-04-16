<?php namespace Whois\Servers\Country;

class Iltld extends \Whois\Server
{
	protected $host = 'whois.isoc.org.il';
	protected $surplus = array('0');
	protected $delimiter = "policy.\n";
	protected $allow = array
	(
		'co.il', 'org.il', 'net.il', 'k12.il', 'gov.il',
		'muni.il', 'idf.il'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No data was found to match the request criteria./', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/validity:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}