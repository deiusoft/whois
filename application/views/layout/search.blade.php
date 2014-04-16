<div class="pull-left">
{{ Form::open('search') }}
	<div class="input-append">
		<input name="query" class="span3" type="text" placeholder="Domain name">
		<button name="type" value="{{ $type }}" class="btn">
			<i class="icon-search"></i>
			Search
		</button>
	</div>
{{ Form::close() }}
</div>