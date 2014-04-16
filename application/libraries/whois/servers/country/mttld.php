<?php namespace Whois\Servers\Country;

class Mttld extends \Whois\Server
{
	protected $host = 'www.nic.org.mt';
	protected $connection_type = 'curl';
	protected $allow = array
	(
		'com.mt', 'org.mt', 'net.mt', 'edu.mt', 'gov.mt'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'https://www.nic.org.mt/dotmt/whois/?'
			.'whois='.$this->domain;

		$this->curl_link($link);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Registered:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/Domain is not registered/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Domain name: $this->domain(.*?)Note: Result details/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[1]));

			$this->body = 'Domain Name: '.$this->domain."\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}