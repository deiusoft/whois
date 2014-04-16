<?php namespace Whois\Servers\Country;

class Vitld extends \Whois\Server
{
	protected $host = 'www.nic.vi';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array('vi');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.nic.vi/whois-lookup/';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		return array
		(
			'domainName' => $this->domain,
			'submitted' => 'true'
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
		if (preg_match("/Registrant \((.*?)HomeFrequently Asked Questions/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[1]));
			$data = preg_replace('/:[\s]+/', ': ', $data);

			$this->body = 'Domain Name: '.$this->domain."\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 'NOT FOUND'."\n";
		}
	}
}