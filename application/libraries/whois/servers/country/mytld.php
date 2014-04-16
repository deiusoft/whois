<?php namespace Whois\Servers\Country;

class Mytld extends \Whois\Server
{
	protected $host = 'whois.domainregistry.my';
	protected $surplus = array('0', '1', '2', '7', '8', '9', '10', '11', '12', '13');
	protected $allow = array
	(
		'my', 'com.my', 'org.my', 'net.my', 'edu.my', 'gov.my',
		'mil.my', 'name.my'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain Name \['.$this->domain.'\] does not exist in database/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/\[Record Expired\][\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/\[Record Created\][\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/\[Record Last Modified\][\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}