<?php namespace Whois\Servers\Country;

class Patld extends \Whois\Server
{
	protected $host = 'www.nic.pa';
	protected $connection_type = 'curl';
	protected $allow = array
	(
		'pa', 'net.pa', 'com.pa', 'ac.pa', 'sld.pa', 'gob.pa',
		'edu.pa', 'org.pa', 'abo.pa', 'ing.pa', 'med.pa', 'nom.pa'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		if ($this->domain)
			$this->curl_link();
	}

	public function curl_link($link = '')
	{
		if (!$link)	
		{
			$parts = $this->domain_explode();

			$link = 'http://www.nic.pa/whois.php?'
				.'nombre_d='.$parts['domain'].'&escojer=.'.$parts['tld'];
		}

		$this->curl_link = $link;

		return $this->curl_link;
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Fecha de Renovaci(.*?)\n(.*?)\n/s', $this->body, $match))
		{
			$match[2] = str_replace('/', '-', $match[2]);
			return strtotime($match[2]);
		}

		return null;
	}

	public function created_on()
	{
		if (preg_match('/Fecha de Creaci(.*?)\n(.*?)\n/s', $this->body, $match))
		{
			$match[2] = str_replace('/', '-', $match[2]);
			return strtotime($match[2]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Fecha de Actualizaci(.*?)\n(.*?)\n/s', $this->body, $match))
		{
			$match[2] = str_replace('/', '-', $match[2]);
			return strtotime($match[2]);
		}

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/El dominio '.$this->domain.' esta disponible para ser Registrado/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Informaci.n del Dominio[\s]+$this->domain(.*?)La informaci&oacute;/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[1]));
			$data = preg_replace_callback
			(
				'/(Contacto[\s]+)|(Fecha[\s]+)|(Organizaci)|(Nombre[\s]+)/',
				create_function
				(
					'$matches',
					'return "\n".trim($matches[0])." ";'
				),
				$data
			);

			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}