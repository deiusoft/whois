<?php namespace Whois\Servers\Country;

class Krtld extends \Whois\Server
{
	protected $host = 'whois.kr';
	protected $surplus = array('last', '2');
	protected $allow = array
	(
		'kr', 'co.kr', 'ne.kr', 'or.kr', 're.kr', 'pe.kr',
		'go.kr', 'mil.kr', 'ac.kr', 'hs.kr', 'ms.kr', 'es.kr',
		'sc.kr', 'kg.kr', 'seoul.kr', 'busan.kr', 'daegu.kr',
		'incheon.kr', 'gwangju.kr', 'daejeon.kr', 'ulsan.kr',
		'gyeonggi.kr', 'gangwon.kr', 'chungbuk.kr', 'chungnam.kr',
		'jeonbuk.kr', 'jeonnam.kr', 'gyeongbuk.kr', 'gyeongnam.kr',
		'jeju.kr', '한글.kr', '한국'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Above domain name is not registered to KRNIC./', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date[\s]+: (.*?)\n/', $this->body, $match))
		{
			$match[1] = trim($match[1], '.');
			$match[1] = str_replace('. ', '/', $match[1]);

			return strtotime($match[1]);
		}

		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registered Date[\s]+: (.*?)\n/', $this->body, $match))
		{
			$match[1] = trim($match[1], '.');
			$match[1] = str_replace('. ', '/', $match[1]);

			return strtotime($match[1]);
		}

		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Last updated Date[\s]+: (.*?)\n/', $this->body, $match))
		{
			$match[1] = trim($match[1], '.');
			$match[1] = str_replace('. ', '/', $match[1]);

			return strtotime($match[1]);
		}
		
		return null;
	}
}