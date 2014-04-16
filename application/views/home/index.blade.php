@layout('layout.main')

@section('content')
	<div class="main_lookup hero-unit">
		<div class="span8">
			<div class="span3 pull-left brand">
				<h1>Whos.it/</h1>
			</div>
			
			<div class="span5 pull-right form">
			{{ Form::open('search','POST', array('class' => 'form-search')) }}
				<div class="input-append">
					<input name="query" class="search-query span3" type="text" placeholder="Domain name">
					<button name="type" value="{{ $type }}" class="btn">
						<i class="icon-search"></i>
						Search
					</button>
				</div>
			{{ Form::close() }}
			</div>
		</div>
	</div>
@endsection

@section('footer')
	<div class="row">
		<div class="span2">
			<p class="pull-right">
				<strong> Who's.it Index: </strong>
			</p>
		</div>

		<div class="span5">
			@for ($i=0; $i < sizeof($index_alpha); $i++)
				<a href="{{ URL::base().'/whois-index/'.strtolower($index_alpha[$i]) }}">
					{{ $index_alpha[$i] }}
				</a>
			@endfor
		</div>
	</div>
@endsection