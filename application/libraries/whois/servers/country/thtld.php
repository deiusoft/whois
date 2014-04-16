<?php namespace Whois\Servers\Country;

class Thtld extends \Whois\Server
{
	protected $host = 'whois.thnic.co.th';
	protected $surplus = array('0');
	protected $allow = array
	(
		'co.th', 'or.th', 'net.th', 'ac.th', 'go.th',
		'in.th', 'mi.th'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No match for \"'.$this->domain.'\"./i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Exp date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Created date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		if (count($sections) > 2)	//'last' => '2'
		{
			array_pop($sections);
			array_pop($sections);
		}

		return $sections;
	}
}