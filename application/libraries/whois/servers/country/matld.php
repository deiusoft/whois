<?php namespace Whois\Servers\Country;

class Matld extends \Whois\Server
{
	protected $host = 'whois.iam.net.ma';
	protected $surplus = array('0');
	protected $delimiter = ")\n";
	protected $allow = array
	(
		'ma', 'co.ma', 'org.ma', 'net.ma', 'ac.ma', 'gov.ma',
		'press.ma'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/%error 230 No Objects Found/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/domain:Created:(.*?)\n/', $this->body, $match))
		{
			$match[1] = substr_replace($match[1], '-', 4, 0);
			$match[1] = substr_replace($match[1], '-', 7, 0);

			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/domain:Updated:(.*?)\n/', $this->body, $match))
		{
			$match[1] = substr_replace($match[1], '-', 4, 0);
			$match[1] = substr_replace($match[1], '-', 7, 0);

			return strtotime($match[1]);
		}
		
		return null;
	}
}