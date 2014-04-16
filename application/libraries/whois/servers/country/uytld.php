<?php namespace Whois\Servers\Country;

class Uytld extends \Whois\Server
{
	protected $host = 'whois.nic.org.uy';
	protected $surplus = array('0', '1', '2', 'last', '1');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'uy', 'com.uy', 'org.uy', 'net.uy', 'edu.uy', 'gub.uy', 'mil.uy'
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

	public function created_on()
	{
		if (preg_match('/Fecha de Creacion:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Ultima Actualizacion:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}