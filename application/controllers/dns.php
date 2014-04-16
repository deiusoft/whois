<?php

class Dns_Controller extends Base_Controller
{
	public function action_index()
	{
		return View::make('dns.index')
			->with('title', 'DNS Check')
			->with('type', 'dns')
			->with('valid', 1);
	}

	public function action_query($domain)
	{
		$domain = strtolower($domain);
		
		Log::write('check', 'dns: '.$domain);
		
		//validate format and chars
		if (! preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $domain))
			return View::make('dns.index')
				->with('title', 'DNS Check')
				->with('type', 'dns')
				->with('valid', 0);

		$dns = new Dns($domain);
		$dns_all = $dns->all();
		$dns_soa = $dns->soa();
		$dns_ns = $dns->ns();
		
		return View::make('dns.info',array
		(
			'title' => $domain.'\'s dns info',
			'all' => $dns_all,
			'soa' => $dns_soa,
			'ns' => $dns_ns,
			'domain' => $domain,
			'type' => 'dns',
		));
	}
}