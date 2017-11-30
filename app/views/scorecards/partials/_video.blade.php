<div id="sticky_wrapper">
	<div id="sticky" class="well">
		@if($fixable)
			<a href="#" id="detach_sticky" class="sticky-toggle">
				Attach <i class="fa fa-unlock"></i>
			</a>
		@endif

		@include('partials/players/jwplayer', ['url' => $video->url])
	</div>
</div>
