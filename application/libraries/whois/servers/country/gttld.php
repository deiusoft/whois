<?php namespace Whois\Servers\Country;

class Gttld extends \Whois\Server
{
	protected $host = 'www.gt';
	protected $connection_type = 'curl';
	protected $allow = array
	(
		'gt', 'com.gt', 'edu.gt', 'net.gt', 'gob.gt',
		'org.gt', 'mil.gt', 'ind.gt'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.gt/Inscripcion/whois.php?domain='.$this->domain;

		$this->curl_link($link);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Fecha de expiraci(.*?)\n(.*?)\n/s', $this->body, $match))
		{
			$match[2] = str_replace('/', '-', $match[2]);
			return strtotime($match[2]);
		}

		return null;
	}

	public function created_on()
	{
		if (preg_match('/Fecha de inscripci(.*?)\n(.*?)\n/s', $this->body, $match))
		{
			$match[2] = str_replace('/', '-', $match[2]);
			return strtotime($match[2]);
		}

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/Nombre de Dominio no registrado/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/$this->domain - REGISTRADO(.*?)Inicio/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[1]));
			$data = preg_replace('/Contacto/', "\nContacto", $data);
			$data = preg_replace('/Fecha/', "\nFecha", $data);
			$data = preg_replace('/Organizaci/', "\nOrganizaci", $data);
			$data = preg_replace('/Servidores:/', "\nServidores:\n", $data);

			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}