@layout('layout.main')

@section('content')
	<div class="row">
		<div class="span9">
			@if (!$valid)
				<div class="alert alert-error">
					Ups!!! The domain name you've entered seems to be invalid!
				</div>
			@endif
			<div class="well">
				<blockquote>
					<p>WHOIS is a query and response protocol widely used for querying databases that store the registered users or assignees of an Internet resource, such as a domain name, an IP address, or an autonomous system. The protocol stores and delivers database content in a human-readable format.</p>
				</blockquote>
			</div>
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