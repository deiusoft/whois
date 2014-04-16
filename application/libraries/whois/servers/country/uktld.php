<?php namespace Whois\Servers\Country;

class Uktld extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.nic.uk';
	protected $surplus = array('last', '4');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'co.uk', 'ac.uk', 'org.uk', 'gov.uk', 'judiciary.uk', 'ltd.uk',
		'me.uk', 'mod.uk', 'net.uk', 'nhs.uk', 'nic.uk', 'org.uk',
		'parliament.uk', 'plc.uk', 'police.uk', 'sch.uk', 'bl.uk',
		'jet.uk', 'nls.uk'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No match for \"'.$this->domain.'\"./i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiry date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registered on:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('before ', '', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}