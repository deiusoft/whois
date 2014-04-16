<?php

class Sitemap_Controller extends Base_Controller
{
	public function action_index($filter1 = '', $filter_max = '', $page = 1)
	{
		$per_page = 19;
		$index_alpha = $url_filter = '';

		if ($filter_max === '')
			$depth = 'ok';
		else 
			$depth = 'sink';

		$filter = strtolower($filter1)
			.strtolower($filter_max);

		if ($filter === '') 
		{
			$index_alpha = array();
			for ($i=0; $i <= 9; $i++)
				$index_alpha[] = $i;
			for ($i=65; $i<=90; $i++)
				$index_alpha[] = chr($i);

			$domains = DB::table('domains')->order_by('name', 'asc')->paginate($per_page);
		}
		else
		{
			$index_alpha = array();
			for ($i=0; $i <= 9; $i++)
				$index_alpha[] = $i;
			for ($i=65; $i<=90; $i++)
				$index_alpha[] = chr($i);

			$url_filter = implode('/', str_split($filter)).'/';

			$domains = DB::table('domains')
				->where('name', 'LIKE', $filter.'%')
				->order_by('name', 'asc')
				->paginate($per_page);
		}
		
		return View::make('sitemap.index')
			->with('title', 'Sitemap')
			->with('depth', $depth)
			->with('domains', $domains)
			->with('url_filter', $url_filter)
			->with('type', 'whois')
			->with('index_alpha', $index_alpha);
	}
}