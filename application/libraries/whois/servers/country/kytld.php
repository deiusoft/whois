<?php namespace Whois\Servers\Country;

class Kytld extends \Whois\Server
{
	protected $host = 'www.nic.ky';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'ky', 'com.ky', 'edu.ky', 'gov.ky', 'net.ky',
		'org.ky'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://kynseweb.messagesecure.com/whois.asp';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array
		(
			'domain_name_pref' => $parts['domain'],
			'domain_name_suff' => '.'.$parts['tld']
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function remove_surplus()
	{
		if (preg_match('/The Domain '.$this->domain.' is[\s]+not a registered/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Whois Information:(.*?)$/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[1]));
			$data = preg_replace('/:[\s]+/', ': ', $data);
			
			$this->body = trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}