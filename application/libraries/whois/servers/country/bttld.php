<?php namespace Whois\Servers\Country;

class Bttld extends \Whois\Server
{
	protected $host = 'www.nic.bt';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'bt', 'com.bt', 'edu.bt', 'gov.bt', 'net.bt',
		'org.bt'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.nic.bt/twhois/whoiss.php';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();
 
		return array
		(
			'dname' => $parts['domain'],
			'dsext' => $parts['tld']
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration date:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation date:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last Renewed:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/'.$this->domain.' has not been registered yet and so available./i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/\($this->domain\)(.*?)&copy; bt Nic./si", $this->body, $match))
		{
			$data = preg_replace('/[\n\r]{1,3}/', "\n", $match[1]);
			$data = preg_replace('/[\n\r]{3,13}/', "\n\n", $data);

			$this->body = 'Domain Name: '.$this->domain."\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}