<?php namespace Whois\Servers\Country;

class Bdtld extends \Whois\Server
{
	protected $host = 'whois.btcl.net.bd';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'bd', 'ac.bd', 'com.bd', 'edu.bd', 'gov.bd', 'mil.bd', 'net.bd',
		'org.bd'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://whois.btcl.net.bd:8080/dotbd/ViewDomain_2.jsp';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$domain = substr($this->domain, 0, -3);
 
		return array
		(
			'dName' => $domain,
			'Submit' => 'SUBMIT'
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Valid&nbsp;Date[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Reg&nbsp;Date[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/Domain you requested does not exist./', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Domain:[\s]+$this->domain\.(.*?)$/si", $this->body, $match))
		{
			$data = preg_replace('/[\n]{2,13}/s', "\n\n", $match[1]);
			
			$this->body = 'Domain Name: '.$this->domain."\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}