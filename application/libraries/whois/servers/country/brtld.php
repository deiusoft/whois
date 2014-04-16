<?php namespace Whois\Servers\Country;

class Brtld extends \Whois\Server
{
	protected $host = 'whois.registro.br';
	protected $surplus = array('0', 'last', '1');
	protected $delimiter = "\n\r";
	protected $allow = array
	(
		'br', 'adm.br', 'adv.br', 'agr.br', 'am.br', 'arq.br', 'art.br',
		'ato.br', 'b.br', 'bio.br', 'blog.br', 'bmd.br', 'cim.br',
		'cng.br', 'cnt.br', 'com.br', 'coop.br', 'ecn.br', 'edu.br',
		'eng.br', 'esp.br', 'etc.br', 'eti.br', 'far.br', 'flog.br',
		'fm.br', 'fnd.br', 'fot.br', 'fst.br', 'g12.br', 'ggf.br',
		'gov.br', 'imb.br', 'ind.br', 'inf.br', 'jor.br', 'jus.br',
		'lel.br', 'mat.br', 'med.br', 'mil.br', 'mus.br', 'net.br',
		'nom.br', 'not.br', 'ntr.br', 'odo.br', 'org.br', 'ppg.br',
		'pro.br', 'psc.br', 'psi.br', 'qsl.br', 'radio.br', 'rec.br',
		'slg.br', 'srv.br', 'taxi.br', 'teo.br', 'tmp.br', 'trd.br',
		'tur.br', 'tv.br', 'vet.br', 'vlog.br', 'wiki.br', 'zlg.br'
	);

	public function __construct($domain)
	{
		$this->domain = $this->get_domain($domain);
 		if (!isset($this->query_string))
			$this->query_string = $this->domain;
	}

	public function available()
	{
		return preg_match('/% No match for domain "'.$this->domain.'"/i', $this->body);
	}
}