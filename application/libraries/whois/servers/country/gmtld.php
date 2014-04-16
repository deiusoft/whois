<?php namespace Whois\Servers\Country;

class Gmtld extends \Whois\Server
{
	protected $host = 'www.nic.gm';
	protected $connection_type = 'curl';
	protected $allow = array('gm');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.nic.gm/scripts/checkdom.asp?dname='.$this->domain;

		$this->curl_link($link);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Registration date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function remove_surplus()
	{
		if (preg_match('/The domain name '.$this->domain.' is still available/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/check \(DIG\) DNS info(.*?)Whois info last updated/si", $this->body, $match))
		{
			$data = preg_replace('/[\n][\s]+/', "\n", trim($match[1]));
			$data = preg_replace('/send request to this contact person/', '', $data);
			$data = preg_replace('/\(see above\)/', "\n", $data);

			$this->body = 'Domain Name: '.$this->domain."\n\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}