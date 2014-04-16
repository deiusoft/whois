<?php namespace Whois\Servers\Country;

class Detld extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.denic.de';
	protected $surplus = array('0');
	protected $allow = array('de');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
				$this->query_string = '-T dn,ace '.$this->domain;
		else
			$this->query_string = '-T dn,ace '.$this->query_string;
	}

	public function available()
	{
		return preg_match('/Status: free/', $this->body);
	}

	public function updated_on()
	{
		if (preg_match('/Changed:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}