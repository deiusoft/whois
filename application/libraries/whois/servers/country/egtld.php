<?php namespace Whois\Servers\Country;

class Egtld extends \Whois\Server
{
	protected $host = 'www.egregistry.eg';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'eg', 'com.eg', 'edu.eg', 'eun.eg', 'gov.eg', 'info.eg',
		'mil.eg', 'name.eg', 'net.eg', 'org.eg', 'sci.eg', 'tv.eg'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://lookup.egregistry.eg/Default2.aspx';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array
		(
			'__VIEWSTATE' => '/wEPDwULLTEzNTIxMjUxNTgPZBYCAgMPZBYEAgsPDxYCHgRUZXh0BYsBPGJyPjxicj5SZXN1bHQ6PHByZT48cCBzdHlsZT1jb2xvcjpSZWQ7IGJhY2tncm91bmQtY29sb3I6V2hpdGU+cHJvcGVydHlkc2FkZGZpbmRlci5lZzxici8+2KfZhNin2LPZhSDZhdiq2KfYrSDZhNmE2KrYs9is2YrZhDwvcD48L3ByZT48YnIvPmRkAg0PDxYCHwBlZGRkdWDLM8wEyW7XhfTzFuMj7971L8I=',
			'__EVENTVALIDATION' => '/wEWEgLIi+CLCwLs0bLrBgL0iP0xAtqMgpwEAvO21IwPAvO2uMMIAtGqsNoDAuqP0u8CAtDiz5ADAt+80qQKAtqMgpwEAsHS+5sMAvO2uMMIAv3EhMcPAt+80qQKAtLmxfUOAu/0i/EEAoznisYGJNQK07AbxN7uLjWhlQ81tjDVQkc=',
			'TextBox1' => $parts['domain'],
			'DropDownlist1' => '.'.$parts['tld'],
			'Button1' => 'بحـــــــــــــث'
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function remove_surplus()
	{
		if (preg_match("/Result:$this->domain(.*?)\n/i", $this->body, $match))
		{
			if (count(explode(' ', trim($match[1]))) === 3)
				$this->body = 'NOT FOUND'."\n";
			if (count(explode(' ', trim($match[1]))) === 5)
				$this->body = 'Domain Name: '.$this->domain."\nStatus: OK\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}