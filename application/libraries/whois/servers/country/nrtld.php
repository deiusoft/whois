<?php namespace Whois\Servers\Country;

class Nrtld extends \Whois\Server
{
	protected $host = 'www.cenpac.net.nr';
	protected $connection_type = 'curl';
	protected $allow = array
	(
		'nr', 'com.nr', 'info.nr', 'net.nr', 'biz.nr',
		'org.nr'
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
		{
			$parts = $this->domain_explode();

			$link = 'http://www.cenpac.net.nr/dns/whois.html?'
				.'subdomain='.$parts['domain']
				.'&tld='.$parts['tld'].'&whois=Submit';
		}

		$this->curl_link = $link;

		return $this->curl_link;
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registration Date:(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function updated_on()
	{
		if (preg_match_all('/Date:(.*?)\n/', $this->body, $match))
			return strtotime(end($match[1]));

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/This domain is not registered /i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Domain Name: $this->domain \(modify\)(.*?)$/si", $this->body, $match))
		{
			$data = preg_replace('/&nbsp;/', "\n", trim($match[1]));
			$data = preg_replace_callback
			(
				'/(Administrative)|(Registration)|(Technical)|(Billing)|(Modifier)|(Organisation)|(Address)|(Country)|(ZIP)|(Phone)|(Fax)|(Email)|(Record Modification)|(Handle)|(Start Domain)|(Expiration)/',
				create_function
				(
					'$matches',
					'return "\n".$matches[0];'
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