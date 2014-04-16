@layout('layout.main')

@section('content')
	<div class="row">
		<div class="span8">
			<ul class="nav nav-tabs">
				<li>
					<a href="{{ URL::to($domain) }}">Whois</a>
				</li>
				<li>
					<a href="{{ URL::to($domain.'/dns') }}">Dns</a>
				</li>
				<li class="active">
					<a>Traffic</a>
				</li>
			</ul>

			@include('layout.search')

			<ul class="breadcrumb">
				<li><a href="{{ URL::home() }}"><i class="icon-home"></i></a> <span class="divider">/</span></li>
				<li><a href="{{ URL::to_asset('/traffic') }}">Traffic</a> <span class="divider">/</span></li>
				<li class="active">{{ strtolower($domain) }}</li>
			</ul>
			
			<div class="well">
				<h4 class="page-header pagination-centered">Contact Information</h4>
				@if ($contact_info['Owner Name'] === '')
					<p>No contact info was available.</p>
				@else
					<dl class="dl-horizontal">
						<dt>Owner Name</dt>
						<dd>{{ $contact_info['Owner Name'] }}</dd>

						<dt>Phone</dt>
						<dd>{{ $contact_info['Phone Number'] }}</dd>

						<dt>Email</dt>
						<dd>{{ $contact_info['Email'] }}</dd>
						@if ($contact_info['Street'] !== '')
							<dt>Address</dt>
							<dd>
								{{ $contact_info['Street'] }},
								{{ $contact_info['City'] }},
								{{ $contact_info['State'] }}
							</dd>
							<dd>
								{{ $contact_info['Postal Code'] }},
								{{ $contact_info['Country'] }}
							</dd>
						@endif
					</dl>
				@endif
			</div>

			<div class="well">
				<h4 class="page-header pagination-centered">Content Data</h4>
				<dl class="dl-horizontal">
					<dt>Title</dt>
					<dd>{{ $content_data['Title'] }}</dd>

					@if ($content_data['Description'] !== '')
						<dt>Description</dt>
						<dd>{{ $content_data['Description'] }}</dd>
					@endif

					<dt>Rank</dt>
					<dd>{{ $content_data['Rank'] }}</dd>

					@if ($content_data['Online Since'] !== '')
						<dt>Online Since</dt>
						<dd>{{ $content_data['Online Since'] }}</dd>
					@endif

					<dt>Median Load Time</dt>
					<dd>{{ $content_data['Speed: Median Load Time'] }}</dd>

					<dt>Speed: Percentile</dt>
					<dd>{{ $content_data['Speed: Percentile'] }}</dd>
					
					@if ($content_data['Adult Content'] !== '')
						<dt>Adult Content</dt>
						<dd>{{ $content_data['Adult Content'] }}</dd>
					@endif

					@if ($content_data['Language'] !== '')
						<dt>Language</dt>
						<dd>{{ $content_data['Language'] }}</dd>
					@endif

					@if ($content_data['Keywords'] !== '')
						<dt>Keywords</dt>
						<dd>{{ $content_data['Keywords'] }}</dd>
					@endif

					<dt>Links In Count</dt>
					<dd>{{ $content_data['Links In Count'] }}</dd>
				</dl>
			</div>

			<div class="well">
				<h4 class="page-header pagination-centered">Traffic Data</h4>
				

				<p><strong>3 Months</strong></p>
				
				<div class="3m row">
					<div class="span2 pull-left">
						<p>Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_3m['Rank']['Value'] }}</span>
						<span>
							@if ($traffic_3m['Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_3m['Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_3m['Rank']['Delta'] != 0)
								{{ abs($traffic_3m['Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="3m row">
					<div class="span2 pull-left">
						<p>Reach Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_3m['Reach Rank']['Value'] }}</span>
						<span>
							@if ($traffic_3m['Reach Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_3m['Reach Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_3m['Reach Rank']['Delta'] != 0)
								{{ abs($traffic_3m['Reach Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="3m row">
					<div class="span2 pull-left">
						<p>Page Views Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_3m['Page Views Rank']['Value'] }}</span>
						<span>
							@if ($traffic_3m['Page Views Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_3m['Page Views Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_3m['Page Views Rank']['Delta'] != 0)
								{{ abs($traffic_3m['Page Views Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="3m row">
					<div class="span2 pull-left">
						<p>Reach Per Million</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_3m['Reach Per Million']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_3m['Reach Per Million']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_3m['Reach Per Million']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_3m['Reach Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_3m['Reach Per Million']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_3m['Reach Per Million']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_3m['Reach Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_3m['Reach Per Million']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

				<div class="3m row">
					<div class="span2 pull-left">
						<p>Page Views Per Million</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_3m['Page Views Per Million']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_3m['Page Views Per Million']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_3m['Page Views Per Million']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_3m['Page Views Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_3m['Page Views Per Million']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_3m['Page Views Per Million']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_3m['Page Views Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_3m['Page Views Per Million']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

				<div class="3m row">
					<div class="span2 pull-left">
						<p>Page Views Per User</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_3m['Page Views Per User']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_3m['Page Views Per User']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_3m['Page Views Per User']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_3m['Page Views Per User']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_3m['Page Views Per User']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_3m['Page Views Per User']['Delta'] < 0)
								<div class="progress">
									<div class="bar-danger" style=" {{ 'width: '.abs($traffic_3m['Page Views Per User']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_3m['Page Views Per User']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>
				<p class="page-header"> </p>

				<p><strong>1 Month</strong></p>
				
				<div class="1m row">
					<div class="span2 pull-left">
						<p>Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_1m['Rank']['Value'] }}</span>
						<span>
							@if ($traffic_1m['Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_1m['Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_1m['Rank']['Delta'] != 0)
								{{ abs($traffic_1m['Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="1m row">
					<div class="span2 pull-left">
						<p>Reach Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_1m['Reach Rank']['Value'] }}</span>
						<span>
							@if ($traffic_1m['Reach Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_1m['Reach Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_1m['Reach Rank']['Delta'] != 0)
								{{ abs($traffic_1m['Reach Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="1m row">
					<div class="span2 pull-left">
						<p>Page Views Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_1m['Page Views Rank']['Value'] }}</span>
						<span>
							@if ($traffic_1m['Page Views Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_1m['Page Views Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_1m['Page Views Rank']['Delta'] != 0)
								{{ abs($traffic_1m['Page Views Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="1m row">
					<div class="span2 pull-left">
						<p>Reach Per Million</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_1m['Reach Per Million']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_1m['Reach Per Million']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_1m['Reach Per Million']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_1m['Reach Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_1m['Reach Per Million']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_1m['Reach Per Million']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_1m['Reach Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_1m['Reach Per Million']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

				<div class="1m row">
					<div class="span2 pull-left">
						<p>Page Views Per Million</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_1m['Page Views Per Million']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_1m['Page Views Per Million']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_1m['Page Views Per Million']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_1m['Page Views Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_1m['Page Views Per Million']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_1m['Page Views Per Million']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_1m['Page Views Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_1m['Page Views Per Million']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

				<div class="1m row">
					<div class="span2 pull-left">
						<p>Page Views Per User</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_1m['Page Views Per User']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_1m['Page Views Per User']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_1m['Page Views Per User']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_1m['Page Views Per User']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_1m['Page Views Per User']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_1m['Page Views Per User']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_1m['Page Views Per User']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_1m['Page Views Per User']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>
				<p class="page-header"> </p>

				<p><strong>7 Days</strong></p>
				
				<div class="7d row">
					<div class="span2 pull-left">
						<p>Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_7d['Rank']['Value'] }}</span>
						<span>
							@if ($traffic_7d['Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_7d['Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_7d['Rank']['Delta'] != 0)
								{{ abs($traffic_7d['Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="7d row">
					<div class="span2 pull-left">
						<p>Reach Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_7d['Reach Rank']['Value'] }}</span>
						<span>
							@if ($traffic_7d['Reach Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_7d['Reach Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_7d['Reach Rank']['Delta'] != 0)
								{{ abs($traffic_7d['Reach Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="7d row">
					<div class="span2 pull-left">
						<p>Page Views Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_7d['Page Views Rank']['Value'] }}</span>
						<span>
							@if ($traffic_7d['Page Views Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_7d['Page Views Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_7d['Page Views Rank']['Delta'] != 0)
								{{ abs($traffic_7d['Page Views Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="7d row">
					<div class="span2 pull-left">
						<p>Reach Per Million</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_7d['Reach Per Million']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_7d['Reach Per Million']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_7d['Reach Per Million']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_7d['Reach Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_7d['Reach Per Million']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_7d['Reach Per Million']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_7d['Reach Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_7d['Reach Per Million']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

				<div class="7d row">
					<div class="span2 pull-left">
						<p>Page Views Per Million</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_7d['Page Views Per Million']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_7d['Page Views Per Million']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_7d['Page Views Per Million']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_7d['Page Views Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_7d['Page Views Per Million']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_7d['Page Views Per Million']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_7d['Page Views Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_7d['Page Views Per Million']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

				<div class="7d row">
					<div class="span2 pull-left">
						<p>Page Views Per User</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_7d['Page Views Per User']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_7d['Page Views Per User']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_7d['Page Views Per User']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_7d['Page Views Per User']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_7d['Page Views Per User']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_7d['Page Views Per User']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_7d['Page Views Per User']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_7d['Page Views Per User']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>
				<p class="page-header"> </p>

				@if (isset($traffic_1d['Rank']['Value']))
				<p><strong>1 Day</strong></p>
				
				<div class="1d row">
					<div class="span2 pull-left">
						<p>Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_1d['Rank']['Value'] }}</span>
						<span>
							@if ($traffic_1d['Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_1d['Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_1d['Rank']['Delta'] != 0)
								{{ abs($traffic_1d['Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="1d row">
					<div class="span2 pull-left">
						<p>Reach Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_1d['Reach Rank']['Value'] }}</span>
						<span>
							@if ($traffic_1d['Reach Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_1d['Reach Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_1d['Reach Rank']['Delta'] != 0)
								{{ abs($traffic_1d['Reach Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="1d row">
					<div class="span2 pull-left">
						<p>Page Views Rank</p>
					</div>

					<div class="span5 pull-right">
					<div class="span3">
						<span>{{ $traffic_1d['Page Views Rank']['Value'] }}</span>
						<span>
							@if ($traffic_1d['Page Views Rank']['Delta'] < 0)
								<i class="icon-arrow-up"></i>
							@elseif ($traffic_1d['Page Views Rank']['Delta'] > 0)
								<i class="icon-arrow-down"></i>
							@endif

							@if ($traffic_1d['Page Views Rank']['Delta'] != 0)
								{{ abs($traffic_1d['Page Views Rank']['Delta']) }}
							@endif
						</span>
					</div>
					</div>
				</div>

				<div class="1d row">
					<div class="span2 pull-left">
						<p>Reach Per Million</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_1d['Reach Per Million']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_1d['Reach Per Million']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_1d['Reach Per Million']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_1d['Reach Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_1d['Reach Per Million']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_1d['Reach Per Million']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_1d['Reach Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_1d['Reach Per Million']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

				<div class="1d row">
					<div class="span2 pull-left">
						<p>Page Views Per Million</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_1d['Page Views Per Million']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_1d['Page Views Per Million']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_1d['Page Views Per Million']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_1d['Page Views Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_1d['Page Views Per Million']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_1d['Page Views Per Million']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_1d['Page Views Per Million']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_1d['Page Views Per Million']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

				<div class="1d row">
					<div class="span2 pull-left">
						<p>Page Views Per User</p>
					</div>

					<div class="span5 pull-right">
						<p class="span1 pull-left">{{ $traffic_1d['Page Views Per User']['Value'] }}</p>
						<p class="span1 pull-right">{{ $traffic_1d['Page Views Per User']['Delta'] }}</p>
						<p class="span3">
							@if ($traffic_1d['Page Views Per User']['Delta'] >= 0)
								<div class="progress">
									<div class="bar bar-success" style=" {{ 'width: '.abs($traffic_1d['Page Views Per User']['Delta']).'%' }} "></div>
									<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($traffic_1d['Page Views Per User']['Delta'])).'%' }} "></div>
								</div>
							@elseif ($traffic_1d['Page Views Per User']['Delta'] < 0)
								<div class="progress">
									<div class="bar bar-danger" style=" {{ 'width: '.abs($traffic_1d['Page Views Per User']['Delta']).'%' }} "></div>
									<div class="bar bar-warning" style=" {{ 'width: '.abs(100 - abs($traffic_1d['Page Views Per User']['Delta'])).'%' }} "></div>
								</div>
							@endif
						</p>
					</div>
				</div>

			</div>
			@endif

			@if (count($subdomains) > 0)
			<div class="well">
				<h4 class="page-header pagination-centered">Subdomains</h4>
			
				<div class="subdomains_header row">
					<div class="span2">
						<p> </p>
					</div>

					<div class="span2">
						<p>Reach</p>
					</div>

					<div class="span2">
						<p>Page Views</p>
					</div>
					
					<div class="span1">
						<p>Page Views Per User</p>
					</div>
				</div>

				@foreach ($subdomains as $name => $subdomain)
					<div class="subdomain row">
						<div class="span2 pull-left">
							<p>{{$name}}</p>
						</div>
						
						<div class="span2">
							<div class="progress span1">
								<div class="bar bar-success" style=" {{ 'width: '.abs($subdomain['Reach']).'%' }} "></div>
								<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($subdomain['Reach'])).'%' }} "></div>
							</div>

							<p class="pull-right">{{$subdomain['Reach']}}</p>
						</div>

						<div class="span2">
							<div class="progress span1">
								<div class="bar bar-success" style=" {{ 'width: '.abs($subdomain['Page Views']).'%' }} "></div>	
								<div class="bar bar-info" style=" {{ 'width: '.abs(100 - abs($subdomain['Page Views'])).'%' }} "></div>
							</div>

							<p>{{$subdomain['Page Views']}}</p>
						</div>

						<div class="span1">
							<p class="pull-right">{{$subdomain['Per User']}}</p>
						</div>

					</div>
				@endforeach
			</div>
			@endif

		</div>
	</div>
	

@endsection