<?php namespace Whois\Servers\Country;

class Botld extends \Whois\Server
{
	protected $host = 'whois.nic.bo';
	protected $allow = array
	(
		'bo', 'com.bo', 'net.bo', 'edu.bo', 'org.bo', 'gob.bo',
		'tv.bo', 'mil.bo', 'int.bo'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		$result = trim($this->body);
		$match = 'whois.nic.bo solo acepta consultas con dominios .bo';

		if ($result === $match)
			return 1;

		return 0;
	}

	public function expires_on()
	{
		if (preg_match('/Fecha de vencimiento:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Fecha de registro:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}