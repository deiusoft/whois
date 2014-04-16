<?php namespace Whois\Servers\Country;

class Mxtld extends \Whois\Server
{
	protected $host = 'whois.mx';
	protected $surplus = array('1');
	protected $delimiter = "\n% NOTICE:";
	protected $allow = array
	(
		'mx', 'com.mx', 'org.mx', 'net.mx', 'edu.mx', 'gob.mx',
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No_Se_Encontro_El_Objeto\/Object_Not_Found/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created On:[\s]+(.*?)\n/', $this->body, $match))
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