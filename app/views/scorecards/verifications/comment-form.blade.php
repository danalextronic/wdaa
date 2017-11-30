{{Form::open(['route' => 'verification.save'])}}
	{{Form::hidden('order_id', $order->id)}}
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				Add new Comment
			</h3>
		</div>

		<div class="panel-body">
			<div class="form-group {{($errors->has('comment')) ? 'has-error' : ''}}">
				{{Form::textarea('comment', null, ['class' => 'form-control'])}}
				@if($errors->has('comment'))
					<span class="help-block">
						{{$errors->first('comment')}}
					</span>
				@endif
			</div>
		</div>

		<div class="panel-footer">
			<div class="satisfaction-controls">
				<label class="radio-inline">
					{{Form::radio('satisfactory', '1', true)}}
					<strong>Satisfactory</strong>
				</label>

				<label class="radio-inline">
					{{Form::radio('satisfactory', '0')}}
					<strong>Unsatisfactory</strong>
				</label>
			</div>
		</div>
	</div>

	<div class="submitForm">
		{{Form::submit('Verify Results', ['class' => 'btn btn-success'])}}
	</div>
{{Form::close()}}
