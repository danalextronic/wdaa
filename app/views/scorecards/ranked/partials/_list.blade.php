@if(!$compare)
	<div class="panel-body">
		@include('scorecards/ranked/partials/_complete-description')
	</div>
@endif

<ul class="list-group rank-listing">
	@foreach($scorecards as $index => $sc)
		<li class="list-group-item">
			<div class="rank-number">
				{{$index + 1}}
			</div>

			<a class="display-comment">
				{{$sc->video->name}}
			</a>

			<div class="comment" style="display:none">
				<blockquote>
					{{$sc->global_comment}}
				</blockquote>
			</div>
		</li>
	@endforeach
</ul>
