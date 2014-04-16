<?php namespace Whois\Servers\Country;

class Tjtld extends \Whois\Server
{
	protected $host = 'www.nic.tj';
	protected $connection_type = 'curl';
	protected $allow = array('tj');

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
		if (!$link)
		{
			$parts = $this->domain_explode();
			$link = 'http://www.nic.tj/cgi/whois2?domain='.$parts['domain'];
		}

		$this->curl_link = $link;

		return $this->curl_link;
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/registration date(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/'.$this->domain.' - no records found/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/domain name$this->domain(.*?)$/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[1]));
			$data = preg_replace_callback
			(
				'/(dns-servers)|(registration data)|(technical contact)|(administrative contact)|(domain owner)/',
				create_function
				(
					'$matches',
					'return "\n".trim($matches[0]);'
				),
				$data
			);

			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}