<?php namespace Whois\Servers\Country;

class Gptld extends \Whois\Server
{
	protected $host = 'dom-eniddc.com';
	protected $connection_type = 'curl';
	protected $curl_post = true;
	protected $allow = array
	(
		'gp', 'com.gp', 'net.gp', 'mobi.gp', 'edu.gp',
		'asso.gp', 'org.gp'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;

		$link = 'https://www.dom-enic.com/whois.html';
		$this->config_curl($link);
	}

	public function generate_curl_post_fields()
	{
		$parts = $this->domain_explode();

		return array
		(
			'domain' => $parts['domain'],
			'extension' => '.'.$parts['tld'],
			'Submit' => 'Soumettre'
		);
	}

	public function available()
	{
		return preg_match('/NOT FOUND/', $this->body);
	}

	public function expires_on()
	{
		if (preg_match('/Expiry Date :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function created_on()
	{
		if (preg_match('/Creation Date :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);
		
		return null;
	}

	public function updated_on()
	{
		if (preg_match('/Updated Date :[\s]+(.*?)\n/', $this->body, $match))
			return strtotime($match[1]);

		return null;
	}

	public function remove_surplus()
	{
		if (count(explode('.', $this->domain)) > 2)
		{
			$this->body = 3;
		}
		else if (preg_match('/Le nom de domaine '.$this->domain.' est disponible/i', $this->body, $match))
		{
			$this->body = 'NOT FOUND'."\n";
		}
		else if (preg_match("/Domaine Name : $this->domain(.*?)Les donn.es de l'annuaire WHOIS de DOMeNIC&nbsp/si", $this->body, $match))
		{
			$data = preg_replace_callback
			(
				'/(Admin )|(Name server )|(Handler )|(Tech )|(Billing )|(Updated )|(Expiry )/',
				create_function
				(
					'$matches',
					'return "\n".$matches[0];'
				),
				trim($match[1])
			);

			//$data = preg_replace('/Admin /', "\nAdmin ", trim($match[1]));
			// $data = preg_replace('/Admin /', "\nAdmin ", trim($match[1]));
			// $data = preg_replace('/Name server /', "\nName server ", $data);
			// $data = preg_replace('/Handler /', "\nHandler ", $data);
			// $data = preg_replace('/Tech /', "\nTech ", $data);
			// $data = preg_replace('/Billing /', "\nBilling ", $data);
			// $data = preg_replace('/Updated /', "\nUpdated ", $data);
			// $data = preg_replace('/Expiry /', "\nExpiry ", $data);
			
			$this->body = 'Domain Name: '.$this->domain."\n";
			$this->body .= trim($data)."\n";
		}
		else
		{
			$this->body = 3;
		}
	}
}