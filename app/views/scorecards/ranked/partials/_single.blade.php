<div class="panel panel-default">
	<div class="panel-heading">
		<div class="pull-right">
			<button type="button" class="close">&times;</button>
		</div>
		<h3 class="panel-title">
			{{$scorecard->video->name}}
		</h3>
	</div>

	<div class="panel-body">

		<div class="col-sm-7 video-player">
			<div id="video-player"></div>

			<script>
				jwplayer("video-player").setup({
					file: "{{$scorecard->video->url}}",
					image: "{{$scorecard->video->image_url}}",
					width: "100%",
					aspectratio: "16:9",
					stretching: "exactfit"
				});
			</script>
		</div>

		<div class="col-sm-5">
			<p class="lead">Leave a Comment below</p>

			<textarea class="form-control global-comment">{{$scorecard->global_comment}}</textarea>
		</div>
	</div>
	<div class="panel-footer">
		@if($scorecard->started_at != $scorecard->updated_at)
			<div class="pull-left">
				Updated
				@if(date("dmY") != $scorecard->updated_at->format("dmY"))
					on {{$scorecard->updated_at->format('m/d/Y \a\t g:iA')}}
				@else
					about {{$scorecard->updated_at->diffForHumans()}}
				@endif
			</div>
		@endif

		<div class="pull-right">
			<button class="btn btn-success save-comment" data-scorecard-id="{{$scorecard->id}}">Save</button>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<div class="divider"></div>
