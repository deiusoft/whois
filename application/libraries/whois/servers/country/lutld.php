<?php namespace Whois\Servers\Country;

class Lutld extends \Whois\Server
{
	protected $host = 'whois.dns.lu';
	protected $surplus = array('0', '1');
	protected $delimiter = "\n% WHOIS ";
	protected $allow = array('lu');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No such domain/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/registered:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}	
		
		return null;
	}
}