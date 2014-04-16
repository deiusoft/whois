<?php namespace Whois\Servers\Country;

class Notld extends \Whois\Server
{
	protected $host = 'whois.norid.no';
	protected $surplus = array('0');
	protected $allow = array
	(
		'no','dep.no', 'fhs.no', 'folkebibl.no', 'fylkesbibl.no',
		'herad.no', 'idrett.no', 'kommune.no', 'mil.no', 'museum.no',
		'uenorge.no', 'priv.no', 'stat.no', 'vgs.no'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No match/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Created:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last updated:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}