<?php namespace Whois\Servers\Country;

class Pntld extends \Whois\Server
{
	protected $host = 'www.government.pn';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'pn', 'co.pn', 'net.pn', 'org.pn'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.pitcairn.pn/cgi-bin/whois.cgi';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array
		(
			'domainName' => $parts['domain'],
			'parentDomain' => $parts['tld'],
			'B1' => 'Whois'
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date[\.]+:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registration Date[\.]+:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated[\.]+:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/The domain name '.$this->domain.' is not currently registered/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/&nbsp;(.*?)$/si", $this->body, $match))
		{
			$data = $match[1];

			$this->body = 'Domain Name: '.$this->domain."\n";
			$this->body .= trim($data)."\n\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}