@extends('layout')
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-5">
			{{ HTML::image("img/map.png", "Map") }}
		</div>
		<div class="col-md-7">
			<div class="search-total">25 @choice('search.found',25)</div>
			<ul class="search-results-list">
				<li class="search-result">
					<a href="#">
						<article class="search-user">
							{{ HTML::image("img/default-user.jpg", "Default user") }}
						</article>
					</a>
				</li>
			</ul>
		</div>
	</div>
</div>
@stop