<ul id="ranked-items">
	@foreach($scorecards as $index => $scorecard)
		<li class="col-md-3 sortable-item" data-scorecard-id="{{$scorecard->id}}">
			<div class="thumbnail">
				<div class="ranked-position">
					{{$index + 1}}
				</div>
				@unless(empty($scorecard->global_comment))
					<div class="completed"></div>
				@endunless
				<img src="{{$scorecard->video->image_url}}" />
				<h4>
					<a href="#" class="load_ranked" data-scorecard-id="{{$scorecard->id}}">
						{{$scorecard->video->name}}
					</a>
				</h4>
			</div>
		</li>
	@endforeach
</ul>
