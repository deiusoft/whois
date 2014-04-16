<?php namespace Whois\Servers\Country;

class Hutld extends \Whois\Server
{
	protected $host = 'whois.nic.hu';
	protected $surplus = array('0');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'hu', '2000.hu', 'agrar.hu', 'bolt.hu', 'casino.hu',
		'city.hu', 'co.hu', 'erotica.hu', 'erotika.hu', 'film.hu',
		'forum.hu', 'games.hu', 'hotel.hu', 'info.hu',
		'ingatlan.hu', 'jogasz.hu', 'konyvelo.hu', 'lakas.hu',
		'media.hu', 'news.hu', 'org.hu', 'priv.hu', 'reklam.hu',
		'sex.hu', 'shop.hu', 'sport.hu', 'suli.hu', 'szex.hu',
		'tm.hu', 'tozsde.hu', 'utazas.hu', 'video.hu'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/ \/ No match/', $this->body);
	}

	public function created_on()
	{
		if (preg_match('/record created:[\s]+(.*?)\n/', $this->body, $match))
		{
			$match[1] = str_replace('.', '/', $match[1]);

			return strtotime($match[1]);
		}
		
		return null;
	}
}