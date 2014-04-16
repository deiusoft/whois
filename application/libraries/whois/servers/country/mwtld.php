<?php namespace Whois\Servers\Country;

class Mwtld extends \Whois\Server
{
	protected $host = 'www.registrar.mw';
	protected $connection_type = 'curl';
	protected $allow = array
	(
		'mw', 'ac.mw', 'co.mw', 'com.mw', 'coop.mw', 'edu.mw',
		'gov.mw', 'int.mw', 'museum.mw', 'net.mw', 'org.mw'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.registrar.mw/index.php?d=0&'
			.'domain='.$this->domain.'&Submit=Search';

		$this->curl_link($link);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Record expires on :(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created :(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated :(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function remove_surplus()
	{
		if (preg_match("/$this->domain[\s]+was NOT found/si", $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/($this->domain)Is Registered to:(.*?)&copy;/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[2]));
			$data = preg_replace_callback
			(
				'/(With the following)|(Administration Contact)|(Technical)|(Billing)|(Dates)/',
				create_function
				(
					'$matches',
					'return "\n\n".$matches[0];'
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