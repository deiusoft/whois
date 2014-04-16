<?php namespace Whois\Servers\Country;

class Pltld extends \Whois\Server
{
	protected $host = 'whois.dns.pl';
	protected $surplus = array('last', '1');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'pl', 'com.pl', 'biz.pl', 'net.pl', 'art.pl', 'edu.pl',
		'org.pl', 'ngo.pl', 'gov.pl', 'info.pl', 'mil.pl',
		'bialystok.pl', 'bydgoszcz.pl', 'czest.pl', 'elk.pl',
		'gda.pl', 'gdansk.pl', 'gorzow.pl', 'kalisz.pl',
		'katowice.pl', 'konin.pl', 'kraków.pl', 'lodz.pl',
		'lublin.pl', 'malopolska.pl', 'nysa.pl', 'olsztyn.pl',
		'opole.pl', 'pila.pl', 'poznan.pl', 'radom.pl', 'rzeszow.pl',
		'slupsk.pl', 'szczecin.pl', 'slask.pl', 'tychy.pl',
		'torun.pl', 'wroc.pl', 'wroclaw.pl', 'waw.pl', 'warszawa.pl',
		'zgora.pl'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No information available about domain name/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/renewal date:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('.', '-', $match[1]);
			return strtotime($match[1]);
		}
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/created:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('.', '-', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/last modified:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('.', '-', $match[1]);
			return strtotime($match[1]);
		}

		return null;
	}
}