<?php namespace Whois\Servers\Country;

class Adtld extends \Whois\Server
{
	protected $host = 'www.nic.ad';
	protected $connection_type = 'curl';
	protected $allow = array('ad');

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'http://www.ompa.ad/bases_dades/dominis2.php?prod='
				.$this->domain
				.'&Submit2=Cercar&tipus=nom_domini&data1=0&data2=0&lang=en';

		$this->curl_link($link);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function remove_surplus()
	{
		if (preg_match('/0r search results./', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Domain name:[\s]+$this->domain(.*?)&nbsp;/si", $this->body, $match))
		{
			$data = $match[1];
			$data = preg_replace('/\/\/ \(download\)/', '', $data);
			
			$this->body = 'Domain Name: '."$this->domain\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}