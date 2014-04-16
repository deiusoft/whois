<?php namespace Whois\Servers\Generic;

class Verisign extends \Whois\Server
{
	protected $port = 43;
	protected $host = 'whois.verisign-grs.com';
	protected $surplus = array('0', '1', 'last', '4');
	protected $allow = array('com', 'net', 'edu');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
		if (!isset($this->query_string))
			$this->query_string = '='.$this->domain;
		else
			$this->query_string = '='.$this->query_string;
	}

	public function next()
	{
		if (preg_match_all('/Whois Server: (.*?)[\s]+/', $this->body, $refer))
			return end($refer[1]);
		
		return null;
	}

	public function available()
	{
		return preg_match('/No match for \"'.$this->domain.'\"\./i', $this->body);
	}

	public function registrar_info()
	{
		if (preg_match('/Domain Name:[\s]+'.$this->domain.'[\s]+(.*?)Name Server:/is', $this->body, $match))
		{
			return $match[1];
		}

		return null;
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)[\s]+/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation Date:[\s]+(.*?)[\s]+/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated Date:[\s]+(.*?)[\s]+/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function nameservers()
	{
		if (preg_match_all('/Name Server:[\s]+(.*?)[\s]+/', $this->body, $pieces))
			return implode("\n", $pieces[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		if (in_array('last', $this->surplus))
		{
			$last = array_pop($this->surplus);
					array_pop($this->surplus);
			

			$section = explode('>>> Last', $sections[2]);

			if (count($section) == 2)
			{
				$sections[2] = $section[0];
				$last--;
			}
				
			for ($i = 1; $i <= $last; $i++) 
				array_pop($sections);
		}

		return $sections;
	}
}
