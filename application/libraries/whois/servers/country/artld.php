<?php namespace Whois\Servers\Country;

class Artld extends \Whois\Server
{
	protected $host = 'www.nic.ar';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'com.ar', 'edu.ar', 'gob.ar', 'gov.ar', 'int.ar', 'mil.ar',
		'net.ar', 'org.ar', 'tur.ar', 'argentina.ar',
		'congresodelalengua3.ar', 'educ.ar', 'gobiernoelectronico.ar',
		'mecon.ar', 'nacion.ar', 'nic.ar', 'promocion.ar', 'retina.ar',
		'uba.ar'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.nic.ar/consdom.html';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array('nombre' => $parts['domain'], 'dominio' => '.'.$parts['tld']);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function remove_surplus()
	{
		var_dump($this->body);
		die();
		if (preg_match('/Este dominio no esta registrado en nuestra base de datos./', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Nombre Dominio :(.*?)La informaci/si", $this->body, $match))
		{
			$data = preg_replace('/[\n]+/', "%", $match[1]);
			$data = preg_replace('/[\s]+/', " ", $data);
			$data = preg_replace('/(% )+/', "\n", $data);
			$data = preg_replace('/:[\s]+\n/', ": ", $data);
			
			$this->body = 'Domain Name: '.$this->domain."\n";
			$this->body .= $data."\n";
		}
		else
		{
			$this->body = 'NOT FOUND'."\n";
		}
	}
}