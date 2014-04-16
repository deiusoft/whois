<?php namespace Whois\Servers\Country;

class Pktld extends \Whois\Server
{
	protected $host = 'www.pknic.net.pk';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'pk', 'com.pk', 'net.pk', 'edu.pk', 'org.pk',
		'fam.pk', 'biz.pk', 'web.pk', 'gov.pk', 'gok.pk',
		'gob.pk', 'gkp.pk', 'gop.pk', 'gos.pk', 'gog.pk'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://pk5.pknic.net.pk/pk5/lookup.PK';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		return array
		(
			'name' => $this->domain,
			'x' => 45,
			'y' => 10
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expire Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Create Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/Domain not found: '.$this->domain.'/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/The Domain record for $this->domain(.*?)Domain Lookup/si", $this->body, $match))
		{
			$data = preg_replace('/&nbsp;/', '', trim($match[1]));
			$data = preg_replace('/[\n][\s]+/', "\n", $data);
			$data = preg_replace('/:[\s]+/', ': ', $data);

			$this->body = trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}