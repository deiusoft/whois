<?php namespace Whois\Servers\Country;

class Vutld extends \Whois\Server
{
	protected $host = 'www.vunic.vu';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array('vu');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.vunic.vu/whois';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		return array
		(
			'pretty' => 1,
			'whois' => $this->domain,
			'B1' => 'Submit'
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expires on:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created on:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last edited on:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/No match for domain '.$this->domain.'/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Domain:[\s]+$this->domain(.*?)- Contact hostmaster/si", $this->body, $match))
		{
			$data = $match[1];

			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}