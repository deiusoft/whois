<?php namespace Whois\Servers\Country;

class Setld extends \Whois\Server
{
	protected $host = 'whois.iis.se';
	protected $surplus = array('0', '1', '2', '3', '4');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'se', 'a.se', 'b.se', 'ac.se', 'bd.se', 'c.se', 'd.se',
		'e.se', 'f.se', 'g.se', 'h.se', 'i.se', 'k.se', 'l.se',
		'm.se', 'n.se', 'o.se', 'p.se', 'r.se', 's.se', 't.se',
		'u.se', 'w.se', 'x.se', 'y.se', 'z.se', 'org.se', 'pp.se',
		'tm.se', 'parti.se', 'press.se'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/\"'.$this->domain.'\" not found./i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/expires:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/modified:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}