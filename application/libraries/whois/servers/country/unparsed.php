<?php namespace Whois\Servers\Country;

	return array
	(
		//'ad',	//curl
		'al', 	//CAPTCHA
		'an',	//31 October 2013 EOL
		'ao',	//cere si ip
		'aq',	//no server
		'hm',	//cu sesiune
		'ar',	//face in js?
		'aw',	//no server
		'az',	//www.whois.az?!
		'ba',	//return img
		'bb',	//captcha
		//'bd',	//curl
		'bf',	//no server
		'bh',	//no server
		'bm',	//complex header
		//'bn',	//iana ret nic.bn dar care nu functioneaza corect 
				//parsat pt a evita rezultate inconsistente
				//fixed
		//'bs',
		//'bt',
		'bv',	//not in use
		'bw',	//no server
		'bz',	//iana nu redirecteaza catre serverul de whois whois.afilias-grs.info
		// 'whois.moniker.com',
		// 'whois.1api.net',		//la cc redirectez mai departe la astea
		// 'whois.enom.com',		//parsed
		// 'whois.bizcn.com',
		//'cd',	//iana nu redirecteaza, whois.nic.cd 	//fixed
		'cf',	//no server
		'cg',	//requests only by email
		'rti.ci',	//domeniu existent dar nu si in bd whois
		'ck',	//no server
		'cl',	//date convert?
		'cm',	//no server
		'cr',	//CAPTCHA
		'cs',	//dead
		'cu',	//js
		'cv',	//login
		//'cy',	
		//'cz',	//socket connect problems
		'dd', 	//not in use
		'dj',	//no server
		//'do',	//curl
		//'eg',	!view_state && event_validation	
		'eh',	//dead
		'er',	//no server
		'es',	//ip restriction
		'et',	//no server
		'eu',	//nu da date doar availability si registrar
		//'fj',	//whois.usp.ac.fj dar iana nu redirecteaza
		'fk',	//no server
		'fm',	//external hosts blocked
		'ga',	//no server
		'gb',	//dead
		'gr',	//CAPTCHA
		'ge',	//no server
		//'gf',	//no server
		'gg',	//requests limitation
		'gh',	//whois failure www.nic.gh/customer/result_c.php
		//'gm',	
		'gn',	//by email
		//'gp',	//CAPTCHA
		'gq',	//no server
		//'gt',
		'gu',	//no server
		'gw',	//only pre-registrations
		'hm',	//sesion
		'hn',	//requests limitations
		'id',	//iana nu redirecteaza	//no server
		'je',	//requests limitation
		'jm',	//no server
		'jo',	//no server
		'kh',	//no server
		'km',	//no server
		'kn',	//no server
		'kp',	//no server
		//'kw',	
		//'ky',
		'kz',	//requests limitations
		//'lb',
		//'lc',	//iana nu redirecteaza	
		//'lk',	//iana nu redirecteaza
		'lr',	//email only
		'ls',	//no server
		'lu',	//requests limitations
		'mc',	//no server
		'mg',	//requests limitations
		'mh',	//inactive
		'mk',	//no server
		'ml',	//no server
		'mm',	//no server
		'mn',	//nic.mn connection refused => used affilias (ok da nu merge pe sTld-uri)
		'mp',	//iana redirecteaza dar serverul de whois e invalid
		//'mq',
		'mr',	//no server
		//'mt',
		'mv',		//no server
		//'mw',
		'my',	//500 req/ip
		'mz',	//no server
		'ne',	//no server
		'ni',	// http://www.nic.ni/index.php?s=4#incenter.php?s=80&ID=55954
		'nl',	//1 req/sec
		'np',	//server down
		//'nr',	
		//'pa',
		//'pf',
		'pg',	//no server
		'ph',	//CAPTCHA
		//'pk',	
		//'pn',
		//'ps',
		'py',	//
		//'ru',	//subdomains error
		'rw',	//CAPTCHA
		'sd',	//no server
		'sj',	//not in use
		'sl',	//iana nu redirecteaza	//whois not yet active
		'sn',	//timeout
		'sr',	//CAPTCHA
		'ss',	//inregistrat dar inca neoperational
		'sv',	//...
		'sz',	//no server
		'td',	//no server
		//'tg',	
		//'tj',
		'tl',	//requests limitations
		'tp',	//being phased out
		'tt',	// ... www.nic.tt/cgi-bin/search.pl
		'tv',	//redirecteaza mai departe : 
				//whois.dynadot.com, whois.name.com, whois.enom.com
		'va',	//no server
		've',	//connection refused
		//'vi',
		'vn',	//server down
		//'vu',
		'ye',	//no server
		'yu',	//dead
		'za',	//CAPTCHA + diff servers
		'zm',	//no server
		'zw',	//no server
	);
