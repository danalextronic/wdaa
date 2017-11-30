<div class="panel-group" id="accordion">
	@foreach($packages as $p)
	<div class="panel panel-default">
		<div class="panel-heading">
			<h4 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#package{{$p->id}}">
					{{$p->name}}
				</a>
			</h4>
		</div>
		<div id="package{{$p->id}}" class="panel-collapse collapse {{($packages->first()->id == $p->id) ? 'in' : ''}}">
			<div class="panel-body">
				@include('scorecards/master/list', ['scorecards' => $p->scorecards])
			</div>
		</div>
	</div>
	@endforeach
</div>
