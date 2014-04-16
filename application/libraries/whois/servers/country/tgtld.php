<?php namespace Whois\Servers\Country;

class Tgtld extends \Whois\Server
{
	protected $host = 'www.nic.tg';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array('tg');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.nic.tg/indexplus.php?pg=verifdom&op=whois';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array
		(
			'tosearch' => $parts['domain'],
			'typedom' => '.'.$parts['tld'],
			'Submit' => 'OK'
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
		if (preg_match('/Le domaine '.$this->domain.' semble ne pas &ecirc;tre enregistr&eacute;/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Recherche sur domaine $this->domain(.*?)$/si", $this->body, $match))
		{
			$data = preg_replace('/[\s]+NS[\s]+/', ' ', trim($match[1]));
			$data = preg_replace('/[\n][\s]+/', "\n", $data);
			$data = preg_replace('/Responsable/', "\nResponsable", $data);

			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}