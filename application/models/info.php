<?php

class Info
{
	public $site;
	public $raw_info;
	public $xml_info;

	protected static $UrlInfoResponseGroup	= 'TrafficData,ContactInfo,ContentData';
	protected static $ServiceHost			= 'awis.amazonaws.com';
	protected static $NumReturn				= 10;
	protected static $StartNum				= 1;
	protected static $SigVersion			= '2';
	protected static $HashAlgorithm			= 'HmacSHA256';

	public function Info($site)
	{
		$this->accessKeyId = Config::get('info.access_key_id');
		$this->secretAccessKey = Config::get('info.secret_access_key');
		$this->site = $site;

		//Cache::forget('traffic_info.'.$this->site);
		$this->raw_info = $this->set_to_cache();
		$this->xml_info = $this->get_xml_info($this->raw_info);
	}

	public function valid()
	{
		if (strpos($this->raw_info, 'Http/1.1 Service Unavailable'))
			return 0;

		return 1;
	}

	public function set_to_cache()
	{
		$obj = $this;

		$data = Cache::remember
		(
			'traffic_info.'.$this->site,
			function() use($obj)
			{				
				return $obj->get_raw_info();
			},
			60 * 24
		);

		if (strpos($data, 'Http/1.1 Service Unavailable'))
			Cache::forget('traffic_info.'.$this->site);

		if (is_null($data))
			Cache::forget('traffic_info.'.$this->site);

		return $data;
	}

	public function contact_info()
	{
		return 	$contact_info = array
		(
			'Owner Name'	=>	(string) $this->xml_info->ContactInfo->OwnerName,
			'Phone Number'	=>	(string) $this->xml_info->ContactInfo->PhoneNumbers->PhoneNumber,
			'Email'			=>	(string) $this->xml_info->ContactInfo->Email,
			'Street'		=>	(string) $this->xml_info->ContactInfo->PhysicalAddress->Streets->Street,
			'City'			=>	(string) $this->xml_info->ContactInfo->PhysicalAddress->City,
			'State'			=>	(string) $this->xml_info->ContactInfo->PhysicalAddress->State,
			'Postal Code'	=>	(string) $this->xml_info->ContactInfo->PhysicalAddress->PostalCode,
			'Country'		=>	(string) $this->xml_info->ContactInfo->PhysicalAddress->Country,
		);
	}

	public function content_data()
	{
		return 	$content_data = array
		(
			'Title'				=>	(string) $this->xml_info->ContentData->SiteData->Title,
			'Description'		=>	(string) $this->xml_info->ContentData->SiteData->Description,
			'Rank'				=>	(string) $this->xml_info->TrafficData->Rank,
			'Online Since'		=>	(string) $this->xml_info->ContentData->SiteData->OnlineSince,
			'Speed: Median Load Time'	=>	(string) $this->xml_info->ContentData->Speed->MedianLoadTime,
			'Speed: Percentile'	=>	(string) $this->xml_info->ContentData->Speed->Percentile,
			'Adult Content'		=>	(string) $this->xml_info->ContentData->AdultContent,
			'Language'			=>	(string) $this->xml_info->ContentData->Language->Locale,
			'Keywords'			=>	(string) $this->xml_info->ContentData->Keywords->Keyword,
			'Links In Count'	=>	(string) $this->xml_info->ContentData->LinksInCount,
		);
	}

	public function subdomains()
	{
		$result = array();

		$subdomains = $this->xml_info->TrafficData->ContributingSubdomains;

		foreach ($subdomains->ContributingSubdomain as $subdomain)
		{
			$offset = ''.$subdomain->DataUrl;
			
			$result[$offset] = array
			(
				'Reach'			=>	(string) $subdomain->Reach->Percentage,
				'Page Views'	=>	(string) $subdomain->PageViews->Percentage,
				'Per User'		=>	(string) $subdomain->PageViews->PerUser,
			);
		}

		return $result;
	}
			
	public function traffic_data($time = '3m')
	{
		$usage_stats = $this->xml_info->TrafficData->UsageStatistics;
		foreach ($usage_stats->UsageStatistic as $statistic)
		{
			$current = 0;
			switch ($time)
			{
				case '3m':
					if ($statistic->TimeRange->Months->count())
						if ($statistic->TimeRange->Months == 3)
							$current = 1;
					break;
				
				case '1m':
					if ($statistic->TimeRange->Months->count())
						if ($statistic->TimeRange->Months == 1)
							$current = 1;
					break;

				case '7d':
					if ($statistic->TimeRange->Days->count())
						if ($statistic->TimeRange->Days == 7)
							$current = 1;
					break;
				
				case '1d':
					if ($statistic->TimeRange->Days->count())
						if ($statistic->TimeRange->Days == 1)
							$current = 1;
					break;

				default:
					# code...
				break;
			}

			if ($current)
			{
				return $result = array
				(
					'Rank'			=>	array
					(
						'Value'	=>	(string) $statistic->Rank->Value,
						'Delta'	=>	(string) $statistic->Rank->Delta,
					),
					'Reach Rank'	=>	array
					(
						'Value'	=>	(string) $statistic->Reach->Rank->Value,
						'Delta'	=>	(string) $statistic->Reach->Rank->Delta,
					),
					'Reach Per Million'	=>	array
					(
						'Value'	=>	(string) $statistic->Reach->PerMillion->Value,
						'Delta'	=>	(string) $statistic->Reach->PerMillion->Delta,
					),
					'Page Views Rank'	=>	array
					(
						'Value'	=>	(string) $statistic->PageViews->Rank->Value,
						'Delta'	=>	(string) $statistic->PageViews->Rank->Delta,
					),
					'Page Views Per Million'	=>	array
					(
						'Value'	=>	(string) $statistic->PageViews->PerMillion->Value,
						'Delta'	=>	(string) $statistic->PageViews->PerMillion->Delta,
					),
					'Page Views Per User'	=>	array
					(
						'Value'	=>	(string) $statistic->PageViews->PerUser->Value,
						'Delta'	=>	(string) $statistic->PageViews->PerUser->Delta,
					),
				);
			}
		}
	}

	public function get_raw_info()
	{
		$query_params = $this->build_query_params('UrlInfo', self::$UrlInfoResponseGroup);

		$sig = $this->generate_signature($query_params);

		$url = 'http://' . self::$ServiceHost . '/?' . $query_params . 
			'&Signature=' . $sig;

		$req = self::make_request($url);

		//pregmatch ret 1 InvalidClientTokenIdThe AWS Access Key Id you provided does not exist in our records.
		return $req;
	}

	/*              Internal functions to use only inside this Class        	*/
	protected function get_xml_info($raw_info)
	{
		$xml = new SimpleXMLElement($raw_info, null, false, 'http://awis.amazonaws.com/doc/2005-07-11');

		if($xml->count() && $xml->Response->UrlInfoResult->Alexa->count())
			return $xml->Response->UrlInfoResult->Alexa;
		else
			return 1;
	}

	protected static function get_timestamp()
	{
		return gmdate("Y-m-d\TH:i:s.\\0\\0\\0\\Z", time()); 
	}

	protected function generate_signature($url_params)
	{
		//string to sign
		$to_sign = "GET\n" . strtolower(self::$ServiceHost) . "\n/\n". $url_params;
		
		//unencoded signature
		$signature = base64_encode(hash_hmac('sha256', $to_sign, $this->secretAccessKey, true));
		
		return urlencode($signature);
	}

	protected function build_query_params($ActionName, $ResponseGroupName)
	{
		$params = array
		(
			'Action'            => $ActionName,
			'ResponseGroup'     => $ResponseGroupName,
			'AWSAccessKeyId'    => $this->accessKeyId,
			'Timestamp'         => self::get_timestamp(),
			'Count'             => self::$NumReturn,
			'Start'             => self::$StartNum,
			'SignatureVersion'  => self::$SigVersion,
			'SignatureMethod'   => self::$HashAlgorithm,
			'Url'               => $this->site
		);

		ksort($params);

		$keyvalue = array();
		foreach($params as $k => $v)
			$keyvalue[] = $k . '=' . rawurlencode($v);

		return implode('&',$keyvalue);
	}

	protected static function make_request($url)
	{
		$ch = curl_init();

		$user_agent     = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.1 '
			. '(KHTML, like Gecko) Chrome/22.0.1207.1 Safari/537.1';

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

		$result = curl_exec($ch);
		curl_close($ch);

		return $result;
	}
}
?>