<?php namespace Whois\Servers\Generic;

class DotBiz extends \Whois\Server
{
	protected $host = 'whois.biz';
	protected $surplus = array('last', '3');
	protected $allow = array('biz');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	// public function next()
	// {
	// 	if (preg_match('/Registrar URL \(registration services\):[\s]+(.*?)\n/', $this->body, $refer))
	// 		return $refer[1];

	// 	return null;
	// }
	
	public function available()
	{
		return preg_match('/Not found: '.$this->domain.'/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Domain Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Domain Registration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Domain Last Updated Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}
