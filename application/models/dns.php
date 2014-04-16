<?php
class Dns
{
	public $host;
	public $records;
	public $soa = array();
	public $name_servers = array();
	public $all = array();

	public function Dns($host, $type = DNS_ALL)
	{
		$this->host = $host;
		$this->records = dns_get_record($this->host,$type);
	}

	public function ns()
	{
		foreach ($this->records as $key => $value) 
		{
			if($value['type'] == 'NS')
			{
				$name_server['NameServer'] = $value['target'];
				$name_server['IP'] = gethostbyname($name_server['NameServer']);
				$this->name_servers[] = $name_server;
			}
		}
		return $this->name_servers;
	}

	public function soa()
	{
		foreach ($this->records as $key => $value) 
		{
			if($value['type'] == 'SOA')
			{
				$this->soa['NameSever'] = $value['mname'];
				$email = $value['rname'];
				$this->soa['Email'] = 'dns'.preg_replace('/^[a-z]+(\.)/','@', $email); 
				$this->soa['SerialNumber'] = $value['serial'];
				$this->soa['Refresh'] = $value['refresh'];
				$this->soa['Retry'] = $value['retry'];
				$this->soa['Expiry'] = $value['expire'];
				$this->soa['Minimum'] = $value['minimum-ttl'];
			}
		}
		return $this->soa;
	}
	
	public function all()
	{
		foreach ($this->records as $key => $record) 
		{
			foreach ($record as $key => &$value) 
			$value = is_array($value) ? implode(' ', $value) : $value;
			$host = $record['host']; unset($record['host']);
			$type = $record['type']; unset($record['type']);
			$class = $record['class']; unset($record['class']);
			$ttl = $record['ttl']; unset($record['ttl']);
			$value = implode(' ', $record);
			$dns_record = array(
							'Record' => $record,
							'Type' => $type,
							'TTL'=> $ttl,
							'Content'=>$value);
			$this->all[] = $dns_record;
		}	
		return $this->all;
	}
}
		
