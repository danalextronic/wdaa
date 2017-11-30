<?php $can_edit = (!isset($editing) || $editing === TRUE) ?>
<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title">
			@if(isset($title))
				{{$title}}
			@else
				Existing Comment{{$verifications->count() != 1 ? 's' : ''}}
			@endif
		</h3>
	</div>

	<ul class="list-group verification-list">
		@foreach($verifications as $v)
			<li class="list-group-item" @if($can_edit)id="item_{{$v->id}}"@endif>

				<div class="verification-display">
					<span class="verification-badge badge badge-{{($v->satisfactory) ? 'success' : 'danger'}}">
						{{($v->satisfactory) ? 'Satisfactory' : 'Unsatisfactory'}}
					</span>
					<!--<h4>
						{{$v->owner->display_name}}
						<small>{{$v->created_at->format('m/d/Y')}}</small>
					</h4>-->
					<blockquote class="comment">{{$v->comment}}</blockquote>

					@if($can_edit)
						<p class="caption" {{($v->created_at == $v->updated_at) ? 'style="display:none"' : ''}}>
							Last Updated: {{$v->updated_at->diffForHumans()}}
						</p>
					@endif
				</div>

				@if($can_edit)
					<div class="verification-edit" style="display:none">
						<h4>Edit</h4>
						<textarea name="comment" rows="20" class="edit-comment form-control">{{$v->comment}}</textarea>

						<div class="pull-left">
							<div class="radio-inline">
								<label class="radio-inline">
									{{Form::radio('satisfactory', '1', ($v->satisfactory == 1))}}
									<strong>Satisfactory</strong>
								</label>

								<label class="radio-inline">
									{{Form::radio('satisfactory', '0', ($v->satisfactory == 0))}}
									<strong>Unsatisfactory</strong>
								</label>
							</div>
						</div>

						<div class="pull-right">
							<button class="btn btn-success save-verification" data-verification-id="{{$v->id}}">
								<i class="fa fa-floppy-o"></i> Save
							</button>
							<button class="btn btn-warning discard-verification" data-verification-id="{{$v->id}}">
								<i class="glyphicon glyphicon-remove"></i> Discard
							</button>
						</div>
						<div class="clearfix"></div>
					</div>

					<div class="verification-buttons">
						@if($v->canEdit())
							<div class="pull-left">
								<button class="btn btn-sm btn-success edit-verification" data-verification-id="{{$v->id}}">
									<i class="glyphicon glyphicon-edit"></i>
									Edit
								</button>

								<!--<button class="btn btn-sm btn-danger remove-verification" data-verification-id="{{$v->id}}">
									<i class="glyphicon glyphicon-trash"></i>
									Delete
								</button>-->
							</div>
						@endif

						@if($v->canVerify())
							<div class="pull-right">
								@unless($v->verified())
									<button class="btn btn-sm btn-success verify" data-verification-id="{{$v->id}}" data-order-id="{{$v->order_id}}">
										<i class="glyphicon glyphicon-ok"></i>
										Verify
									</button>
								@endunless
							</div>
						@endif
						<div class="clearfix"></div>
					</div>
				@endif
			</li>
		@endforeach
	</ul>
</div>
