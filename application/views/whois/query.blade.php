@layout('layout.main')

@section('header')
	<div class="pull-right">
		<button data-domain="{{ $domain }}" class="refresh_btn btn">
			<i class="icon-refresh"></i>
			Refresh
		</button>
	</div>
@endsection

@section('content')
	<div class="row">
		<div class="span9">
			<ul class="breadcrumb">
				<li><a href="{{ URL::home() }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
				<li><a href="{{ URL::home() }}">Whois</i></a> <span class="divider">/</span></li>
				<li class="active">{{ $domain }}</li>
			</ul>

			@if (!$available)
				<div class="alert-error availability">
					<strong>{{ $domain }}</strong> is unavailable for registration
				</div>
			@else
				<div class="alert-success availability">
					<strong>{{ $domain }}</strong> is available for registration
				</div>
			@endif

			<div class="accordion" id="accordion2">
			@foreach ($data as $server)
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="{{ '#collapse'.$i }}">
							{{ $server->host() }}
						</a>
					</div>
					@if ($i == count($data))
					<div id="{{ 'collapse'.$i }}" class="accordion-body collapse in">
					@else
					<div id="{{ 'collapse'.$i }}" class="accordion-body collapse">
					@endif
						<div class="accordion-inner">
							@if (is_numeric($server->get_body()))
								<div class="accordion_pre alert-error">
									Ups!!! We couldn't reach the whois server responsible for this tld.
									Please try again later.
								</div>
							@else
								<pre class="accordion_pre">{{ $server->get_body() }}</pre>
							@endif
						</div>
					</div>
				</div>
				<?php $i++; ?>				
			@endforeach
			</div>

			@if ($expires_on || $created_on || $updated_on)
			<div class="well dates">
				<h4 class="page-header pagination-centered">Important Dates</h4>
				<dl class="dl-horizontal">
					@if ($expires_on)
						<dt>Expiration Date:</dt>
						<dd>{{date("m/d/Y h:i:s A T",$expires_on)}}</dd>
					@endif
					@if ($created_on)
						<dt>Creation Date:</dt>
						<dd>{{date("m/d/Y h:i:s A T",$created_on)}}</dd>
					@endif
					@if ($updated_on)
						<dt>Last Update Date:</dt>
						<dd>{{date("m/d/Y h:i:s A T",$updated_on)}}</dd>
					@endif
				</dl>
			</div>
			@endif
		</div>
	</div>
@endsection

@section('footer')
	<strong> 
		<a href="{{ URL::base().'/whois-index' }}">
			Who's.it Index: 
		</a>
	</strong>

	@for ($i=0; $i < sizeof($index_alpha); $i++)
		<a href="{{ URL::base().'/whois-index/'.strtolower($index_alpha[$i]) }}">
			{{ $index_alpha[$i] }}
		</a>
	@endfor
@endsection