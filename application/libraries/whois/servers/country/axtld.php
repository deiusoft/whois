<?php namespace Whois\Servers\Country;

class Axtld extends \Whois\Server
{
	protected $host = 'whois.ax';
	protected $surplus = array('0', '1');
	protected $delimiter = "\n\r";
	protected $allow = array('ax');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No records matching '.$this->domain.' found./i', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}