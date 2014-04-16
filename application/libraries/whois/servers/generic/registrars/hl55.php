<?php namespace Whois\Servers\Generic\Registrars;

class Hl55 extends \Whois\Server
{
	protected $host = 'whois.55hl.com';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}
}