<?php namespace Whois\Servers\Generic\Registrars;

class Dreamhost extends \Whois\Server
{
	protected $host = 'whois.dreamhost.com';
	protected $surplus = array('0', '1', '2', '3', '4', '5', '6');

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

	public function auxiliary_remove($sections)
	{
		array_pop($sections);

		$section = explode('DreamHost', $sections[count($sections) - 1]);
		if (count($section) == 2)
			$sections[count($sections) - 1] = $section[0];

		return $sections;
	}
}