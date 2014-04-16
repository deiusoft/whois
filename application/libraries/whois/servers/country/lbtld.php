<?php namespace Whois\Servers\Country;

class Lbtld extends \Whois\Server
{
	protected $host = 'www.aub.edu.lb';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'com.lb', 'edu.lb', 'gov.lb', 'net.lb', 'org.lb'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.aub.edu.lb/cgi-bin/lbdr.pl';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array
		(
			'cn' => $parts['domain'],
			'B1' => 'Search'
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Activated:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace(' -', '', trim($match[1]));
			return strtotime($match[1]);
		}
		
		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/Search Results for/i', $this->body, $match))
		{
			if (!preg_match('/'.$this->domain.'/i', $this->body, $match))
			{
				$this->body = 'NOT FOUND'."\n";
			}
			else if (preg_match("/Domain$this->domain(.*?)$/si", $this->body, $match))
			{
				$data = preg_replace('/-c/', '-c: ', trim($match[1]));
				$data = preg_replace('/NameServer/', 'NameServer: ', $data);
				$data = preg_replace('/Date/', "\nDate: ", $data);
				$data = preg_replace('/Activated/', 'Activated: ', $data);
				$data = preg_replace('/Status/', 'Status: ', $data);
				$data = preg_replace('/LBDRA/', "\nLBDRA: ", $data);
				$data = preg_replace('/Descr/', 'Descr: ', $data);
				$data = preg_replace('/Trademark/', "\nTrademark: ", $data);

				$this->body = 'Domain Name: '.$this->domain."\n\n";
				$this->body .= trim($data)."\n";
			}
			else
			{
				$this->body = 3;
			}
		}
		else
		{
			$this->body = 3;
		}
	}
}