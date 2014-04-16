<?php

class Whois_Controller extends Base_Controller
{
	public function action_index()
	{
		$index_alpha = Sitemap::get_filters();

		return View::make('whois.index')
			->with('valid', 1)
			->with('type', 'whois')
			->with('title', 'WHOIS Search')
			->with('index_alpha', $index_alpha);
	}

	public function action_query($domain)
	{
		$domain = strtolower($domain);
		$index_alpha = Sitemap::get_filters();

		Log::write('check', 'whois: '.$domain);

		//Cache::forget('whois.'.$domain);
		$whois = Cache::remember
		(
			'whois.'.$domain,
			function() use($domain)
			{
				return new Whois\Whois($domain);
			},
			60 * 24
		);

		$data = $whois->get_all_data();

		if ($data === 0)
			$valid = 0;
		else
			$valid = $data[0]->valid();

		if (!$valid)
			return View::make('whois.index')
				->with('valid', 0)
				->with('type', 'whois')
				->with('title', 'WHOIS Search')
				->with('index_alpha', $index_alpha);

		$data = $whois->email_mask($data);
		$available = $whois->available();

		$domain = $data[sizeof($data) - 1];
		$domain = $domain->get_query_domain();

		$meta = array('title' => '', 'ip' => '');
		if ($valid && !$available)
		{
			if (!Domain::where('name', '=' , $domain)->first())
					@Domain::create(array('name' => $domain));

			$meta['title'] = Domain::get_domain_title($domain);
			
			$ip = gethostbyname($domain);
			if ($ip != $domain)
				$meta['ip']	= $ip;
		}

		$expires_on = $whois->expires_on();
		$created_on = $whois->created_on();
		$updated_on = $whois->updated_on();

		if (is_numeric(end($data)->get_body()))
			Cache::forget('whois.'.$domain);

		return View::make('whois.query', array
		(
			'i'	=> 1,
			'data' => $data,
			'meta' => $meta,
			'type' => 'whois',
			'valid' => $valid,
			'domain' => $domain,
			'available' => $available,
			'expires_on' => $expires_on,
			'created_on' => $created_on,
			'updated_on' => $updated_on,
			'index_alpha' => $index_alpha,
			'title' => $domain.'\'s whois info',
		));
	}

	public function action_refresh()
	{
		$domain = Input::get('domain');

		Cache::forget('whois.'.$domain);

		return $this->action_query($domain);
	}
}