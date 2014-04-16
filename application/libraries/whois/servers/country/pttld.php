<?php namespace Whois\Servers\Country;

class Pttld extends \Whois\Server
{
	protected $host = 'whois.dns.pt';
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'pt', 'com.pt', 'org.pt', 'net.pt', 'edu.pt', 'gov.pt',
		'int.pt', 'nome.pt', 'publ.pt'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/'.$this->domain.' no match/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date \(dd\/mm\/yyyy\):[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation Date \(dd\/mm\/yyyy\):[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}