<?php

class Domain extends Eloquent 
{
	public static $timestamps = true;

	public static function get_domain_title($domain)
	{
		$ch = curl_init('www.'.$domain);

		$user_agent	=	'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 '
						. '(KHTML, like Gecko) Chrome/22.0.1207.1 Safari/537.1';

		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 3);

		$data = curl_exec($ch);
		curl_close($ch);

		if (preg_match('/<title(.*?)>(.*?)<\/title>/', $data, $match))
			return trim($match[2]);
		else
			return null;
	}
}