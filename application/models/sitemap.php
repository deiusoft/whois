<?php

class Sitemap 
{
	public static function get_filters()
	{
		$index_alpha = array();
		for ($i=0; $i <= 9; $i++)
			$index_alpha[] = $i;
		for ($i=65; $i<=90; $i++)
			$index_alpha[] = chr($i);

		return $index_alpha;
	}
}