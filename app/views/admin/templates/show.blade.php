@include('partials/packages/jwplayer')

@if(!is_null($template->items))
	@section('external_css')
		{{HTML::style("assets/css/scorecard.css")}}
	@stop
@endif

@section('content')
	<div class="pull-right">
		{{link_to_route('admin.templates.index', 'Return To Template Listing', [], ['class' => 'btn btn-info'])}}
	</div>

	<div class="page-header">
		<h1>
			{{$template->name}}
		</h1>
	</div>

	@if(!empty($template->description))
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Template Description</h3>
			</div>

			<div class="panel-body">
				{{$template->description}}
			</div>
		</div>

		<div class="divider"></div>
	@endif

	<!-- Scorecard Options Panel -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">Template Highlights</h3>
		</div>

		<div class="panel-body">
			<div class="row">
				<div class="col-sm-3">
					<p>
						Scoring Type: 
						{{($template->type == 'R') ? 'Drag and Drop' : 'Scored'}}
					</p>

					@if($template->owner)
						<p>
							Created By: {{link_to_route('profile', $template->owner->display_name, $template->owner->username)}}
						</p>
					@endif

					<p>
						Created on {{$template->created_at->format('m/d/Y')}}
					</p>
					<p>
						Updated on {{$template->updated_at->format('m/d/Y')}}
					</p>
				</div>

				@if($template->type == 'S')
					<div class="col-sm-3">
						<p>
							Test Rows: 
							<span class="label label-{{($template->use_test_rows) ? 'success' : 'danger'}}">
								{{$template->use_test_rows ? 'Yes' : 'No'}}
							</span>
						</p>
						@if($template->use_test_rows)
							<p>
								Test Row Label: {{$template->test_rows_label}}
							</p>
							<p>
								Markers:
								<span class="label label-{{($template->use_markers) ? 'success' : 'danger'}}">
									{{$template->use_markers ? 'Yes' : 'No'}}
								</span>
							</p>
						@endif

						<p>
							Coefficients:
							<span class="label label-{{($template->use_coef) ? 'success' : 'danger'}}">
								{{$template->use_coef ? 'Yes' : 'No'}}
							</span>
						</p>

						@if($template->use_coef)
							<p>
								Manual Coefficient:
								<span class="label label-{{($template->manual_coef) ? 'success' : 'danger'}}">
									{{$template->manual_coef ? 'Yes' : 'No'}}
								</span>
							</p>
						@endif
					</div>

					<div class="col-sm-3">
						<p>
							Overall Rows:
							<span class="label label-{{($template->use_overall_rows) ? 'success' : 'danger'}}">
								{{$template->use_overall_rows ? 'Yes' : 'No'}}
							</span>
						</p>

						@if($template->use_overall_rows)
							<p>
								Overall Rows Label: {{$template->overall_rows_label}}
							</p>
						@endif

						<p>
							Errors:
							<span class="label label-{{($template->use_errors) ? 'success' : 'danger'}}">
								{{$template->use_errors ? 'Yes' : 'No'}}
							</span>
						</p>

						<p>
							Row Comment:
							<span class="label label-{{($template->use_row_comment) ? 'success' : 'danger'}}">
								{{$template->use_row_comment ? 'Yes' : 'No'}}
							</span>
						</p>

						<p>
							Row Ideas:
							<span class="label label-{{($template->use_ideas) ? 'success' : 'danger'}}">
								{{$template->use_ideas ? 'Yes' : 'No'}}
							</span>
						</p>
					</div>
				@endif

				<div class="col-sm-3">
					<p>
						Overall Remarks:
						<span class="label label-{{($template->use_global_comment) ? 'success' : 'danger'}}">
							{{$template->use_global_comment ? 'Yes' : 'No'}}
						</span>
					</p>

					@if($template->type == 'S')
						<p>
							Manual Score:
							<span class="label label-{{($template->use_manual_score) ? 'success' : 'danger'}}">
								{{$template->use_manual_score ? 'Yes' : 'No'}}
							</span>
						</p>
					@endif
				</div>
			</div>
		</div>
	</div><!-- End Scorecard Options Panel -->

	<div class="divider"></div>

	@unless($template->packages->isEmpty() && $template->videos->isEmpty())
		<div class="row">
			@unless($template->videos->isEmpty())
				<div class="col-sm-{{($template->packages->isEmpty()) ? 12 : 6}}">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								Videos Assigned To Template
							</h3>
						</div>

						<ul class="list-group">
							@foreach($template->videos as $video)
								<li class="list-group-item">
									<img src="{{$video->image_url}}" style="width:30px;height:20px;" />
									<a href="{{$video->url}}" class="load_video" title="{{$video->name}}">
										{{$video->name}}
									</a>
								</li>
							@endforeach
						</ul>
					</div>
				</div>
			@endunless

			@unless($template->packages->isEmpty())
				<div class="col-sm-{{($template->videos->isEmpty()) ? 12 : 6}}">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">
								Packages Assigned to Template
							</h3>
						</div>

						<div class="panel-body">
							<table class="table table-striped">
								<thead>
									<tr>
										<th>Package Name</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($template->packages as $package)
										<tr>
											<td>
												{{link_to_route('admin.packages.show', $package->name, $package->id)}}
											</td>
											<td>
												<a class="btn btn-default" href="{{URL::route('admin.packages.edit', $package->id)}}">
													<i class="glyphicon glyphicon-edit"></i>
													Edit
												</a>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			@endunless
		</div>

		<div class="divider"></div>
	@endunless

	@unless(is_null($items))
		@include('admin/templates/partials/_sample-template')
	@endunless
@stop
