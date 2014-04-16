<?php namespace Whois\Servers\Country;

class Autld extends \Whois\Server
{
	protected $host = 'whois.audns.net.au';
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'com.au', 'net.au', 'edu.au', 'org.au', 'gov.au',
		'csiro.au', 'asn.au', 'id.au', 'vic.au', 'nt.au',
		'act.au', 'nsw.au', 'qld.au', 'sa.au', 'tas.au', 'wa.au',
		'act.gov.au', 'act.edu.au', 'nsw.gov.au', 'school.nsw.edu.au',
		'nt.gov.au', 'nt.gov.au', 'qld.gov.au',	'eq.edu.au', 'qld.edu.au',
		'sa.gov.au', 'sa.edu.au', 'tas.gov.au', 'tas.edu.au',
		'vic.gov.au', 'vic.edu.au', 'wa.gov.au', 'wa.edu.au'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/No Data Found/', $this->body);
	}

	public function updated_on()
	{
		if (preg_match('/Last Modified:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}
}