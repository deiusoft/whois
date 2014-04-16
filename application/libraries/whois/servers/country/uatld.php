<?php namespace Whois\Servers\Country;

class Uatld extends \Whois\Server
{
	protected $host = 'whois.ua';
	protected $surplus = array('0');
	protected $allow = array
	(
		'ua', 'com.ua', 'org.ua', 'net.ua', 'edu.ua', 'gov.ua',
		'in.ua', 'at.ua', 'pp.ua', 'ck.ua', 'cn.ua', 'cv.ua',
		'dp.ua', 'dn.ua', 'if.ua', 'kh.ua', 'ks.ua', 'km.ua',
		'kr.ua', 'lg.ua', 'lt.ua', 'mk.ua', 'od.ua', 'pl.ua',
		'rv.ua', 'te.ua', 'uz.ua', 'vn.ua', 'zp.ua', 'zt.ua',
		'cherkassy.ua', 'chernigov.ua', 'chernovtsy.ua',
		'crimea.ua', 'dnepropetrovsk.ua', 'donetsk.ua',
		'ivano-frankivsk.ua', 'kharkov.ua', 'kherson.ua',
		'khmelnitskiy.ua', 'kiev.ua', 'kirovograd.ua', 'lugansk.ua',
		'lutsk.ua', 'lviv.ua', 'nikolaev.ua', 'odessa.ua',
		'poltava.ua', 'rovno.ua', 'sebastopol.ua', 'yalta.ua',
		'sumy.ua', 'ternopil.ua', 'uzhgorod.ua', 'vinnica.ua',
		'zaporizhzhe.ua', 'zhitomir.u'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No entries found for '.$this->domain.'/i', $this->body);
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

	public function auxiliary_remove($sections)
	{
		if (count($sections) > 2)
		{
			array_pop($sections);
			array_pop($sections);
		}

		return $sections;
	}
}