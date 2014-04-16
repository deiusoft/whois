<?php

class Info_Controller extends Base_Controller
{

	public function action_index()
	{
		return View::make('info.index')
			->with('title', 'Traffic Information')
			->with('type', 'traffic')
			->with('valid', 1);
	}

	public function action_query($domain)
	{
		$domain = strtolower($domain);

		Log::write('check', 'traffic: '.$domain);

		//validate format and chars
		if (! preg_match('/^(?:[-A-Za-z0-9]+\.)+[A-Za-z]{2,6}$/', $domain))
			return View::make('info.index')
				->with('title', 'Traffic Information')
				->with('type', 'traffic')
				->with('valid', 0);

		$awis = new Info($domain);

		if ($awis->valid() == 0)
			return View::make('error.awis_down')
				->with('title', 'Traffic Information Error')
				->with('type', 'traffic');

		$awis->set_to_cache();

		$contact_info	= $awis->contact_info();
		$content_data	= $awis->content_data();
		$subdomains		= $awis->subdomains();		
		$traffic_3m		= $awis->traffic_data('3m');
		$traffic_1m		= $awis->traffic_data('1m');
		$traffic_7d		= $awis->traffic_data('7d');
		$traffic_1d		= $awis->traffic_data('1d');

		return View::make('info.query', array
		(
			'title' => $domain.'\'s traffic info',
			'contact_info' 	=> $contact_info,
			'content_data' 	=> $content_data,
			'subdomains' 	=> $subdomains,
			'traffic_3m' 	=> $traffic_3m,
			'traffic_1m' 	=> $traffic_1m,
			'traffic_7d' 	=> $traffic_7d,
			'traffic_1d' 	=> $traffic_1d,
			'domain'		=> $domain,
			'type'			=> 'traffic',
		));
	}
}