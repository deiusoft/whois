<?php namespace Whois\Servers\Country;

class Uztld extends \Whois\Server
{
	protected $host = 'whois.cctld.uz';
	protected $surplus = array('0', '1');
	protected $allow = array('uz');
	
	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/Sorry, but domain: \"'.$this->domain.'\", not found/i', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiration Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated Date:[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function auxiliary_remove($sections)
	{
		if (count($sections) > 4)
		{
			array_pop($sections);
			array_pop($sections);

			for ($i= 3; $i <= 6 ; $i++) 
				$this->surplus[] = ''.$i;
		}
		else
		{
			array_pop($sections);
		}

		return $sections;
	}
}