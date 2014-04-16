<?php namespace Whois\Servers\Country;

class Pftld extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.registry.pf';
	protected $surplus = array('0');
	protected $allow = array('pf', 'com.pf');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain unknown/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expire \(JJ\/MM\/AAAA\) :[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created \(JJ\/MM\/AAAA\) :[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last renewed \(JJ\/MM\/AAAA\) :[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('/', '-', $match[1]);
			return strtotime($match[1]);
		}
		
		return null;
	}
}