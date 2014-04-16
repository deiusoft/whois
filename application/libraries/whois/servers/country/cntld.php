<?php namespace Whois\Servers\Country;

class Cntld extends \Whois\Server
{
	protected $host = 'whois.cnnic.cn';
	protected $allow = array
	(
		'cn', 'com.cn', 'net.cn', 'edu.cn', 'org.cn', 'gov.cn', 'ac.cn',
		'mil.cn', 'ah.cn', 'bj.cn', 'cq.cn', 'fj.cn', 'gd.cn', 'gs.cn',
		'gz.cn', 'gx.cn', 'ha.cn', 'hb.cn', 'he.cn', 'hi.cn', 'hk.cn',
		'hl.cn', 'hn.cn', 'jl.cn', 'js.cn', 'jx.cn', 'ln.cn', 'mo.cn',
		'nm.cn', 'nx.cn', 'qh.cn', 'sc.cn', 'sd.cn', 'sh.cn', 'sn.cn',
		'sx.cn', 'tj.cn', 'tw.cn', 'xj.cn', 'xz.cn', 'yn.cn', 'zj.cn'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/no matching record./', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Registration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}