@include('partials/packages/jwplayer')

<?php $type = (isset($scorecard->type) ? $scorecard->type : (isset($type) ? $type : '')); ?>
<div class="pull-right">
	
	@if(!$compare)
		@if($type == 'MASTER')
			{{link_to_route('master.dashboard', 'Return to Listing', [], ['class' => ' btn btn-info'])}}
		@else
			{{link_to_route('profile', 'Return to Listing', $user->username, ['class' => 'btn btn-info'])}}
		@endif
	@endif
	
</div>

<div class="page-header">
	<h1>
		{{$template->name}}
		
		@if($compare)
			<br /><small>Comparison Scorecard</small>
		@endif
	</h1>
</div>


