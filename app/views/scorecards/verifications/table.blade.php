<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th>Scorecards Completed</th>
			@if($tab != strtolower(Order::$verification_states['incomplete']))
				<th>Last Updated</th>
			@endif
		</tr>
	</thead>
	<tbody>
		@foreach($orders as $order)
			<tr>
				<td>
					{{link_to_route('verification.single', $order->owner->display_name, $order->id)}}
				</td>
				<td>
					{{$order->date_scorecards_completed->format('m/d/Y \a\t g:iA')}}
				</td>
				@if($tab != strtolower(Order::$verification_states['incomplete']))
					<td>
						@unless($order->verifications->isEmpty())
							{{$order->verifications->last()->updated_at->format('m/d/Y \a\t g:iA')}}
						@else
							N/A
						@endunless
					</td>
				@endif
			</tr>
		@endforeach
	</tbody>
</table>
