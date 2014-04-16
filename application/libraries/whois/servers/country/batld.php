<?php namespace Whois\Servers\Country;

class Batld extends \Whois\Server
{
	protected $host = 'www.nic.ba';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'ba', 'org.ba', 'net.ba', 'gov.ba', 'mil.ba', 'edu.ba'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://nic.ba/lat/menu/view/13';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		switch ($parts['tld'])
		{
			case 'org.ba':	$type = 2;	break;
			case 'net.ba':	$type = 3;	break;
			case 'gov.ba':	$type = 4;	break;
			case 'mil.ba':	$type = 5;	break;
			case 'edu.ba':	$type = 6;	break;

			default:	$type = 1;	break;
 		}

		return array
		(
			'whois_input' => 'ba5a6a4d394199b487318bcfae18f7b923e93901',
			'whois_select_name' => $parts['domain'],
			'whois_select_type' => $type,
			'submit' => 'Pokaži WHOIS podatke',
			'submit_check' => 'on',
		);
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