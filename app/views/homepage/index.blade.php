@extends('layouts.master')

@section('content')
@if(Input::get('msg'))
	<div class="alert alert-success">
		  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		@lang('site.contact_success')
	</div>
@endif

<div class="container-narrow">
<div class="jumbotron">
	<h1>Judge Evaluation Program</h1>
	<h2>Western Dressage AssociationÂ® of America</h2>
	<p class="lead">An online scoring system that allows candidate Western Dressage judges to evaluate the 2013 Western Dressage tests and receive direct feedback from a Judge Evaluator.</p>
</div>

<div class="enroll-button">
	{{link_to_route('packages.enroll', 'Online Tuition $' . intval($package->cost), $package->slug, ['class' => 'btn btn-success'])}}
</div>

<hr />

<div class="row text-center"><h2>How it works </h2></div>
<div class="row marketing">
    <div class="col-md-6">
    	<div class="item">
	      <h4>Review all 16 Videos</h4>
	      <p>Once signed up for the program, candidate judge have access to their own online library containing a separate video for each of the 16 tests.  A dashboard allows the candidate to see the status of each video as either â€œto be doneâ€� or â€œevaluation complete.â€�  A candidate can enter and exit the program at any time so that they are able to work at their own pace and convenience.<br /><br /></p>
      </div>

      <div class="item">
		<h4>Complete Scorecard with Comments</h4>
		<p>After a video is selected, the candidate starts the video in the player and watches through each movement of the test.  At the completion of each movement, the candidate clicks on the player in order to pause the video, at which point they can scroll down to the electronic scorecard for that test and assign a score for the movement along with their written comments.</p>
      </div>
    </div>


    <div class="col-md-6">
		<div class="item">
			<h4>Score Comparison</h4>
			<p>Once the test evaluations are complete, the online system compares all of the scores and comments for each test to a master scorecard that has been completed by a WDAA panel.  Candidates see their completed scorecard alongside the master scorecard so they can compare their scores and comments line by line alongside the master scorecard.  They also have the ability to review the video while analyzing the comparison.</p>
		</div>

		<div class="item">
			<h4>Feedback from Evaluation Panel</h4>
			<p>After all 16 tests have been scored by the candidate judge, members of the Judge Education Task Force will review all 16 of the scored tests.  Candidates will then receive written comments about their evaluations along with a summary comparison of their final score for each test compared to the score assigned by the panel.  Candidates will be advised whether their scoring has resulted in a "Satisfactory" or "Unsatisfactory" completion of this component of the judge education program.</p>
		</div>
    </div>
</div>
@stop
