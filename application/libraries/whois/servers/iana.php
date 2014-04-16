<?php namespace Whois\Servers;

class Iana extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.iana.org';
	protected $surplus = array('9', '10');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function valid()
	{
		return preg_match('/ This query returned 1 object/', $this->body);
	}

	public function next()
	{
		if (preg_match('/refer:[\s]+(.*?)\n/', $this->body, $refer))
			return $refer[1];
		
		return null;
	}

	public function curl_next()
	{
		if (preg_match('/remarks:[\s]+Registration information:[\s]+(.*?):\/\/(.*?)[\/\n]/', $this->body, $refer))
			return $refer[2];
		
		return null;
	}
}
