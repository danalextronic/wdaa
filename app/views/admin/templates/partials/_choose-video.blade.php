<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			Choose Video
		</h3>
	</div>

	<div class="panel-body">
		<p class="lead">
			Select each video below that you wish to assign to this template
		</p>

		<div class="template-videos">
			@foreach(array_chunk($videos->toArray(), 3, true) as $row)
				<div class="row">
					@foreach($row as $video)
						<div class="col-md-4">
							<div class="thumbnail">
								<a href="{{$video['url']}}" class="load_video" title="{{$video['name']}}">
									<img src="{{$video['image_url']}}" />
								</a>

								<div class="pull-left">
									<h4>
										<a href="{{$video['url']}}" class="load_video" title="{{$video['name']}}">
											{{$video['name']}}
										</a>
									</h4>
								</div>
								<div class="pull-right">
									<input type="checkbox" name="videos[]" value="{{$video['id']}}" @if(isset($current_videos) && in_array($video['id'], $current_videos))checked="checked"@endif />
								</div>
							</div>
						</div>
					@endforeach
				</div>
			@endforeach
		</div>
	</div>
</div>
