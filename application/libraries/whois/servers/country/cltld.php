<?php namespace Whois\Servers\Country;

class Cltld extends \Whois\Server
{
	protected $host = 'whois.nic.cl';
	protected $surplus = array('last', '3');
	protected $allow = array('cl');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/: no existe/', $this->body);
	}

	public function updated_on()
	{
		if (preg_match('/(Database last updated on):[\s]+(.*?)\n/', $this->body, $match))
		{
			// TO DO -> transform from spanish to english
			return strtotime($match[1]);
		}
		return null;
	}
}