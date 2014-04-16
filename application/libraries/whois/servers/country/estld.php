<?php namespace Whois\Servers\Country;

class Estld extends \Whois\Server
{
	protected $host = 'whois.nic.es';
	protected $surplus = array('-1');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'es', 'com.es', 'nom.es', 'org.es', 'edu.es', 'gob.es'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function auxiliary_remove($sections)
	{
		if (preg_match('/not authorised  or  has exceeded the established limit/i', $sections[7]))
			return array($sections[7]);

		return $sections;
	}
}