@layout('layout.main')

@section('content')
	<div class="row">
		<div class="span9">
			<ul class="breadcrumb">
				<li><a href="{{ URL::home() }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
				<li><a href="{{ URL::to_asset('whois-index') }}">Whois-index</i></a> </li>
				@if ($url_filter)
					<? $crumbs = explode('/', trim($url_filter, '/')); ?>
					<span class="divider">/</span>
					@if (!isset($crumbs[1]))
						<li class="active">{{ $crumbs[0] }}</li>
					@else
						<li><a href="{{ URL::to_asset('whois-index/'.$crumbs[0]) }}">{{ $crumbs[0] }}</i></a><span class="divider">/</span></li>
						<li class="active">{{ $crumbs[1] }}</li>
					@endif
				@endif
			</ul>

			@if ($index_alpha !== '' && $depth === 'ok' && !empty($domains->results))
				<div class="breadcrumb">
					<strong> Filter by starting with: </strong>
					<span class="pull-right">
					@for ($i=0; $i < sizeof($index_alpha); $i++)
						<a href="{{ URL::base().'/whois-index/'.$url_filter.strtolower($index_alpha[$i]) }}">
							{{ $index_alpha[$i] }}
						</a>
					@endfor
					</span>
				</div>
			@endif

			@if (empty($domains->results))
				<div class="alert alert-info">
					It looks like there aren't domain names that
					<strong>
						start with 
						<span class="label">
							{{ trim(implode('', explode('/', $url_filter)), '/') }}
						</span>
					</strong>
					in our index. Better start searching!!
				</div>
			@else
				@foreach ($domains->results as $domain)
				<div style="text-align: center">
					<a href="{{ URL::base().'/'.$domain->name }}">
						{{ $domain->name }}
					</a>
				</div>
				@endforeach
			@endif
		</div>
	</div>
@endsection

@section('footer')
	{{ $domains->links() }}
@endsection