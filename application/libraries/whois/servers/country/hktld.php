<?php namespace Whois\Servers\Country;

class Hktld extends \Whois\Server
{
	protected $host = 'whois.hkirc.hk';
	protected $surplus = array('0', '1', '2', 'last', '11');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'hk', 'com.hk', 'org.hk', 'net.hk', 'edu.hk', 'gov.hk', 'idv.hk'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/The domain has not been registered./', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiry Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain Name Commencement Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}