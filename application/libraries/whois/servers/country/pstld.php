<?php namespace Whois\Servers\Country;

class Pstld extends \Whois\Server
{
	protected $host = 'www.nic.ps ';
	protected $connection_type = 'curl';
	protected $allow = array
	(
		'ps', 'com.ps', 'net.ps', 'org.ps', 'edu.ps',
		'gov.ps', 'plo.ps', 'sec.ps'
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
		if (!$link)	
			$link = 'http://www.pnina.ps/domains/whois/?z=ps&'
				.'d='.$this->domain;

		$this->curl_link = $link;

		return $this->curl_link;
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function remove_surplus()
	{
		if (preg_match('/The domain \"'.$this->domain.'\" has not been registered/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match('/The domain \"'.$this->domain.'\" has already been registered/i', $this->body, $match))
		{
			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($match[0]).".\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}