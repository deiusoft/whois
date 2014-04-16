<?php namespace Whois\Servers\Country;

class Bstld extends \Whois\Server
{
	protected $host = 'www.register.bs';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'bs', 'com.bs', 'net.bs', 'edu.bs', 'org.bs',
		'gov.bs', 'we.bs'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://register.bs/cgi-bin/search.pl';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$domain = $this->domain;
		return array('name' => $domain,);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date[\s]+(.*?) /', $this->body, $match))
		{
			$match[1] = str_replace('-', '/', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Updated[\s]+(.*?) /', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/The Domain Name '.$this->domain.' has not yet been Registered/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Domain Name[\s]+$this->domain(.*?)$/si", $this->body, $match))
		{
			$data = preg_replace('/DNS/', "\n\nDNS", $match[1]);
			$data = preg_replace('/Expiration/', "\n\nExpiration", $data);
			$data = preg_replace('/Administrative/', "\n\nAdministrative", $data);
			$data = preg_replace('/Technical/', "\n\nTechnical", $data);
			$data = preg_replace('/Billing/', "\n\nBilling", $data);
			
			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}