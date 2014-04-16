@layout('layout.main')

@section('content')

	<div class="row">
		<div class="span8">
			@include('layout.search')
			@if (!$valid)
				<div class="alert alert-error">
					Ups!!! The domain name you've entered seems to be invalid!
				</div>
			@endif
			<div class="well">
				<blockquote>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
				</blockquote>
			</div>
		</div>
	</div>
@endsection