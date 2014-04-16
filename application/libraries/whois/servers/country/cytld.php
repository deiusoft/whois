<?php namespace Whois\Servers\Country;

class Cytld extends \Whois\Server
{
	protected $host = 'www.nic.cy';
	protected $connection_type = 'curl';
	protected $allow = array
	(
		'ac.cy', 'net.cy', 'gov.cy', 'org.cy', 'pro.cy',
		'name.cy', 'ekloges.cy', 'tm.cy', 'ltd.cy', 'biz.cy',
		'press.cy', 'parliament.cy', 'com.cy'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		if ($this->domain)
			$this->curl_link();
	}

	public function curl_link($link = '')
	{
		$parts = $this->domain_explode();
		$what = substr($parts['tld'], 0, -3);

		$this->curl_link = 'http://www.nic.cy/nslookup/dns_get_record.php?'
			.'search='.$parts['domain']
			.'&what='.$what
			.'&submit=Search';

		return $this->curl_link;
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function remove_surplus()
	{
		if (preg_match('/The domain name '.$this->domain.'is NOT REGISTERED!/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/NS records(.*?)$/si", $this->body, $match))
		{
			$data = preg_replace('/[\t]/', "\n", $match[1]);
			$data = preg_replace('/Authoritative/', "\n\nAuthoritative", $data);

			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 'NOT FOUND'."\n";
		}
	}
}