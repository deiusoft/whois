<?php namespace Whois\Servers\Country;

class Jptld extends \Whois\Server
{
	protected $host = 'whois.jprs.jp';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'jp', 'co.jp', 'or.jp', 'ne.jp', 'ac.jp', 'ad.jp', 'ed.jp',
		'go.jp', 'gr.jp', 'lg.jp', 'geo.jp'

	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		$this->query_string = $this->domain.'/e';
	}

	public function available()
	{
		return preg_match('/No match!!/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/\[Expires on\][\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/\[Created on\][\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/\[Last Updated\][\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}