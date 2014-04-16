<?php namespace Whois\Servers\Country;

class Dztld extends \Whois\Server
{
	protected $host = 'whois.nic.dz';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'dz', 'com.dz', 'net.dz', 'edu.dz', 'org.dz', 'gov.dz',
		'asso.dm', 'pol.dm', 'art.dm'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/NO OBJECT FOUND!/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Date de creation#[\.]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}
			
		
		return null;
	}
}