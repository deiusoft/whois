<?php namespace Whois\Servers\Country;

class Lytld extends \Whois\Server
{
	protected $host = 'whois.nic.ly';
	protected $surplus = array('last', '1');
	protected $delimiter = "\n--\n";
	protected $allow = array
	(
		'ly', 'com.ly', 'org.ly', 'net.ly', 'edu.ly', 'gov.ly',
		'plc.ly', 'sch.ly', 'med.ly', 'id.ly'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Not found/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expired:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}