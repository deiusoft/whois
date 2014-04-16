<!doctype html public "✰">
<!--[if lt IE 7]> <html lang="en-us" class="lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="en-us" class="lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="en-us" class="lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-us"> <!--<![endif]-->
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	@if (!isset($title))
	<title>WHOIS Search - Whos.it</title>
	@else
	<title>{{ $title }} - Whos.it</title>
	@endif

	@if (!isset($meta))
	<meta name='description' content='Whos.it - Free, online whois lookup for any top level domain name or IP address. Find available domains or details about the registered ones.'>
	@elseif ($meta['ip'])
	<meta name='description' content="Whois information for {{ $domain }}. - {{ $domain }} is hosted at {{ $meta['ip'] }} -  {{ $meta['title'] }}.">
	@else
	<meta name='description' content="Whois information for {{ $domain }}. {{ $meta['title'] }}">
	@endif

	<meta name="viewport" content="width=device-width">
	{{ HTML::style('css/bootstrap.css') }}
	{{ HTML::style('css/style.css') }}
</head>

<body>
	<div class="container">
	<div class="row">
		<div class="span9 pull-left">
			<div id="header">
				@include('layout.search')
				@yield('header')
			</div>

			<div id="content">
				@yield('content')
			</div>

			<div id="footer">
				@yield('footer')
			</div>
		</div>

		<div id="sidebar" class="span3 pull-right">
			<script type="text/javascript"><!--
			google_ad_client = "ca-pub-9272815986011653";
			/* whos.it side */
			google_ad_slot = "4174432488";
			google_ad_width = 160;
			google_ad_height = 600;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
		</div>
	</div>		
	</div>
	{{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js') }}
	{{ HTML::script('js/bootstrap.js') }}
	{{ HTML::script('js/script.js') }}

	<script type="text/javascript">
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-37472269-1']);
		_gaq.push(['_setDomainName', 'whos.it']);
		_gaq.push(['_trackPageview']);
		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
	</script>
</body>
</html>