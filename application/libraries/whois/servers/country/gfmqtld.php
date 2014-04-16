<?php namespace Whois\Servers\Country;

class GfMqtld extends \Whois\Server
{
	protected $host = 'dom-enic.com';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array('gf', 'mq');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'https://www.dom-enic.com/whois.html';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array
		(
			'domain' => $parts['domain'],
			'extension' => '.'.$parts['tld'],
			'Submit' => 'Soumettre'
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Record expires on[\s]+(.*?)\./', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created on[\s]+(.*?)\./', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated on[\s]+(.*?)\./', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/Le nom de domaine '.$this->domain.' est disponible/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Domain Name : $this->domain(.*?)Les donn.es de l'annuaire WHOIS de DOMeNIC&nbsp/si", $this->body, $match))
		{
			$data = preg_replace('/[#]+(.*?)Domain name: '.$this->domain.'/s', '', trim($match[1]));
			$data = preg_replace('/[\n][\s]+[\n]/', "\n%\n", $data);
			$data = preg_replace('/[\n][\s]+/', "\n", $data);
			$data = preg_replace('/%/', "\n", $data);
			
			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}