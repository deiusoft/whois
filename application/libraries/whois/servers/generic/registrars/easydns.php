<?php namespace Whois\Servers\Generic\Registrars;

class EasyDns extends \Whois\Server
{
	protected $host = 'whois.easydns.com';
	protected $surplus = array('2', 'last', '7');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function expires_on()
	{
		if (preg_match('/Record expires on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Record created on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Record last updated on[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		$sections[1] = 'Domain Name: '.$this->domain;

		if (in_array('last', $this->surplus))
		{
			$last = array_pop($this->surplus);
					array_pop($this->surplus);
			
			for ($i = 1; $i <= $last; $i++) 
				array_pop($sections);
		}

		return $sections;
	}
}