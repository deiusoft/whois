<?php namespace Whois\Servers\Country;

class Tntld extends \Whois\Server
{
	protected $host = 'whois.ati.tn';
	protected $surplus = array('0');
	protected $allow = array
	(
		'tn', 'com.tn', 'ens.tn', 'fin.tn', 'gov.tn', 'ind.tn',
		'intl.tn', 'nat.tn', 'net.tn', 'org.tn', 'info.tn',
		'perso.tn', 'tourism.tn', 'edunet.tn', 'rnrt.tn', 'rns.tn',
		'rnu.tn', 'mincom.tn', 'agrinet.tn', 'defense.tn'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Domain '.$this->domain.' not found/i', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/Acivated[\s]+: (.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}