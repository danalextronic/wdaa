<?php

/**
* valid_url
*
* Checks whether a URL is valid or not for form submission
*
* @param string $url - a string that we wish to test
* @return bool
* @author Eric Paulsen
*/
function valid_url($url) 
{
	return filter_var($url, FILTER_VALIDATE_URL);
}
	
/**
 * is_you
 * 
 * Checks to see whether the logged in user matches the accepted user id
 * 
 * @param  integer
 * @return boolean
 */
function is_you($user_id)
{
	return (Auth::check() && $user_id == Auth::user()->id);
}

/**
 * jsonResponse
 * 
 * Method that handles the response of the JSON objects
 * 
 * 
 * @param  boolean $status
 * @param  string  $message
 * @param  array   $additional
 * @return json
 */
function jsonResponse($status, $message, $additional = array())
{
	$status = (bool) $status;

	if($status === true) {
		$status = 'success';
	}
	else {
		$status = 'fail';
	}

	$data = [
		'result' => $status,
		'message' => $message
	];

	if(!empty($additional)) {
		$data = array_merge($data, $additional);
	}

	return Response::json($data);
}

/**
 * buildDashboardList
 * 
 * Method that builds our dashboard list
 * 
 * @return Illuminate\View
 */
function buildDashboardList()
{
	$dashboards = Auth::user()->buildDashboardList();

	if(count($dashboards) > 0) {
		return View::make('layouts.partials._dashboards')
			->with('dashboards', $dashboards);
	}
}

/**
 * scorecardLink
 * 
 * Determines where to route us depending on review status
 * 
 * Only for learner scorecards
 * @return string $route_name
 */
function scorecardLink($is_reviewed)
{
	return ($is_reviewed) ? 'profile.comparison_scorecard' : 'profile.learner_scorecard';
}
	
/**
 * compareText
 * 
 * Displays the comparison text (only for comparison scorecard view)
 * 
 * @param  Scorecard $scorecard
 * @param  boolean   $comparison
 * @return string
 */
function compareText(Scorecard $scorecard, $comparison)
{
	if($comparison) {
		if($scorecard->type == 'MASTER') {
			return Str::properize(Lang::get('site.master'));
		}
		else {
			return is_you($scorecard->user_id) ? 'Your' : Str::properize($scorecard->owner->first_name);
		}
	}
}

/**
 * panelColor
 * 
 * Displays a corresponding CSS panel color based on scorecard type
 * compatible with Twitter Bootstrap
 * 
 * @param  Scorecard $scorecard
 * @param  boolean   $comparison
 * @return string
 */
function panelColor(Scorecard $scorecard, $comparison)
{
	if($comparison) {
		if($scorecard->type == 'MASTER') {
			return 'panel-success';
		}
		else {
			return 'panel-info';
		}
	}

	return 'panel-default';
}

/**
 * scorecardRowSettings
 * 
 * Method that sets up table column widths
 * 
 * @param  ScorecardTemplate $template
 * @return array
 */
function scorecardRowSettings(ScorecardTemplate $template)
{
	// Stuff for the number of rows and row width.
	$cols_width = 585;
	$num_cols = 0;
	if($template->use_manual_score == 0) {
		if($template->use_errors == 1) {
			$cols_width = $cols_width - 70;
			$num_cols++;
		}

		if($template->use_coef == 1) {
			$cols_width = $cols_width - 70;
			$num_cols++;	
		}

		
		$cols_width = $cols_width - 70;
		$num_cols++;
	}

	return [
		$cols_width, $num_cols
	];
}
	
/**
 * buildPointsDropdown
 * 
 * Builds the HTML for the points dropdown
 * 
 * @param  string  $points    
 * @param  string  $id        
 * @param  float $precision  
 * @param  boolean $editable  
 * @return string
 */
function buildPointsDropdown($points, $id, $precision, $editable = false)
{
	$points = ($points) ? number_format(ceil($points/$precision)*$precision,2) : false;

	if(!$editable) {
		return $points;
	}

	// build points dropdown list	
	$options = ['' => ''];
	for($i=10;$i>=0;$i=$i-$precision) {
		$options[number_format($i, 2)] = number_format($i, 2);
	}

	$atts = [
		'class' => 'form-control sc-drop',
		'id' => 'points_'.$id,
		'data-item-id' => $id,
		'data-column' => 'points'
	];

	return Form::select('rows['.$id.'][points]', $options, $points, $atts);
}

/**
 * buildPointsDropdown
 * 
 * Builds the HTML for the coefficient dropdown
 * 
 * @param  string  $coef    
 * @param  string  $id
 * @param  integer $min     
 * @param  integer $max     
 * @param  integer $step 
 * @param  boolean $editable  
 * @return string
 */
function buildCoefficientDropdown($coef, $id, $min = 1, $max = 9, $step = 1, $editable = false)
{
	if(!$editable) return $coef;

	$options = [];
	for($i = $min; $i <= $max; $i += $step) {
		$options[$i] = $i;
	}

	$atts = [
		'class' => 'sc-drop form-control',
		'id' => 'coef_'. $id,
		'data-item-id' => $id,
		'data-column' => 'coef',
	];

	return Form::select('rows['.$id.'][coef]', $options, $coef, $atts);
}

/**
 * buildErrorDropdown
 * 
 * Build the dropdown list for errors
 * 
 * @param  string  $errors
 * @param  string  $id      
 * @param  integer $min     
 * @param  integer $max     
 * @param  integer $step    
 * @param  boolean $editable
 * @return string
 */
function buildErrorDropdown($errors, $id, $min = 1, $max = 9, $step = 1, $editable = false)
{
	if(!$editable) return $errors;

	$options = [];
	for($i = 0; $i <= 3; $i++) {
		$options[$i] = $i;
	}

	$atts = [
		'class' => 'sc-drop form-control',
		'id' => 'errors_'. $id,
		'data-item-id' => $id,
		'data-column' => 'errors',
	];

	return Form::select('rows['.$id.'][errors]', $options, $errors, $atts);
}

/**
 * buildRowComment
 * 
 * Builds the HTML for the row comment
 * 
 * 
 * @param  string  $comment
 * @param  string  $id      
 * @param  boolean $editable
 * @return string           
 */
function buildRowComment($comment, $id, $editable = false)
{
	if(!$editable) return $comment;

	$atts = [
		'class' => 'form-control',
		'data-item-id' => $id,
		'data-column' => 'comments'
	];

	return Form::text('rows['.$id.'][comments]', $comment, $atts);
}
