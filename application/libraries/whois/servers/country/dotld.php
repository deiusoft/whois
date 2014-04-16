<?php namespace Whois\Servers\Country;

class Dotld extends \Whois\Server
{
	protected $host = 'www.nic.do';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'do', 'art.do', 'com.do', 'edu.do', 'gob.do', 'gov.do', 'mil.do', 'net.do',
		'org.do', 'sld.do', 'web.do'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.nic.do/whois.php3';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();
 
		return array('T1' => $parts['domain'], 'do' => $parts['tld'], 'B1' => 'Buscar');
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function remove_surplus()
	{
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
			$this->body = 3;
		}
	}
}