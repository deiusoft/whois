<?php namespace Whois\Servers\Generic\Registrars;

class AlpineDomains extends \Whois\Server
{
	protected $host = 'whois.alpinedomains.com';
	protected $surplus = array('0');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		$last = array_pop($sections);
		$last = explode('The data in', $last);

		if (count($last) == 2)
			$sections[] = $last[0];

		return $sections;
	}
}