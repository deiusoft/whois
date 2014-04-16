<?php namespace Whois\Servers\Country;

class Sotld extends \Whois\Server
{
	protected $host = 'whois.nic.so';
	protected $surplus = array('0', 'last', '1');
	protected $allow = array('so');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Not found: '.$this->domain.'/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated On:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}