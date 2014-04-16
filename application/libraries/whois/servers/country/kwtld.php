<?php namespace Whois\Servers\Country;

class Kwtld extends \Whois\Server
{
	protected $host = 'www.kw';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'com.kw', 'edu.kw', 'gov.kw', 'net.kw',
		'org.kw'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.kw/mainrs.asp';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array
		(
			'domname' => $parts['domain'],
			'domtype' => $parts['tld'],
			'submit' => 'Submit'
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiry Date:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace(' -', '', trim($match[1]));
			return strtotime($match[1]);
		}
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registration Date:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace(' -', '', trim($match[1]));
			return strtotime($match[1]);
		}
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Renewal Date:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace(' -', '', trim($match[1]));
			return strtotime($match[1]);
		}
		
		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/The domain '.$this->domain.' is available for registration/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/The domain[\s]+$this->domain is registered\.(.*?)&nbsp;/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[1]));
			$data = preg_replace('/:[\s]+/', ': ', $data);
			$data = preg_replace('/Last Renewal/', "\nLast Renewal", $data);
			
			$this->body = 'Domain Name: '.$this->domain."\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}