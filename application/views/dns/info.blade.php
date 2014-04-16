@layout('layout.main')

@section('content')
	<div class="row">
		<div class="span8">
			<ul class="nav nav-tabs">
				<li>
					<a href="{{ URL::to($domain) }}">Whois</a>
				</li>
				<li class="active">
					<a>Dns</a>
				</li>
				<li>
					<a href="{{ URL::to($domain.'/traffic') }}">Traffic</a>
				</li>
			</ul>

			@include('layout.search')

			<ul class="breadcrumb">
				<li><a href="{{ URL::home() }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
				<li><a href="{{ URL::to_asset('/dns') }}">Dns</a> <span class="divider">/</span></li>
				<li class="active">{{ strtolower($domain) }}</li>
			</ul>

			<div class="well">
				<h3>Name Servers</h3>
				<table class="table" border="1">
					<thead>
						<tr>
							<th>Name Server</th>
							<th>IP</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($ns as $name_server)
							<tr>
								@foreach($name_server as $key => $value)
									<td>{{$value}}</td>
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="well">
				<h3>SOA</h3>
				<table class="table" border="1">
					<tbody>
						@foreach ($soa as $key => $value)
							<tr>
								<td>{{$key}}</td>
								<td>{{$value}}</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="well">
				<h3>DNS Records</h3>
				<table class="table" border="1">
					<thead>
						<tr>
							<th>Host</th>
							<th>Type</th>
							<th>TTL</th>
							<th>Content</th>
						</tr>
					</thead>
					<tbody>	
						@foreach ($all as $server)
							<tr>	
								@foreach($server as $key => $value)
									@if($key == 'Record')
										<td>{{$domain}}</td>
									@else
										<td>{{$value}}</td>
									@endif
								@endforeach
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
		</div>
	</div>
@endsection