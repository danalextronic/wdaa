<?php

use CSG\Scorecards\Rows as ScorecardBuilder;
use CSG\Scorecards\DragAndDrop as RankedScorecard;

class BaseController extends Controller {

	public function __construct()
	{
		if(App::environment('development')) 
		{
			$this->beforeFilter(function()
			{
			    Event::fire('clockwork.controller.start');
			});

			$this->afterFilter(function()
			{
			    Event::fire('clockwork.controller.end');
			});
		}
	}
	
	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}

	/**
	 * Inject state data into our javascript
	 * 
	 * @access protected
	 * @param  mixed $userdata
	 * @return void
	 */
	protected function getStatesUrl($userdata = null)
	{
		JavaScript::put([
			'states_url' => URL::route('states.get'),
			'user' => (!is_null($userdata)) ? $userdata : []
		]);
	}

	/**
	 * viewScorecard
	 * 
	 * Loads data and view for displaying scorecard
	 * Build a request from a child controller that handles the display
	 * and then call this function with the appropriate data in order to load it
	 * 
	 * @access public
	 * @param  Scorecard $scorecard  
	 * @param  array $options
	 * @return void
	 */
	public function viewScorecard(Scorecard $scorecard, array $options = array())
	{
		$sc_data = ScorecardBuilder::instance($scorecard->template_id)->build($scorecard);
		$sc_data = array_merge($sc_data, $this->loadDefaults($options));

		if(!isset($sc_data['editable'])) {
			$sc_data['editable'] = (($scorecard->type == 'MASTER' && !$sc_data['compare']) || ($scorecard->type == 'LEARNER' && $scorecard->complete == 0));
		}

		$sc_data['fixable'] = (
			($sc_data['template']->use_test_rows == 1 || $sc_data['template']->use_overall_rows == 1 ) 
			&& count($sc_data['items']) > 0 
			&& $sc_data['template']->type != 'R'
		);

		// pass data to our javascript
		// but only if we can edit the scorecard
		if($sc_data['editable']) {
			$urls = [
				'save_row' => URL::route('scorecard.save_row'),
				'save_score' => URL::route('scorecard.save_score'),
				'save_comment' => URL::route('scorecard.save_comment'),
				'validate_scorecard' => URL::route('scorecard.validate_scorecard'),
				'save_scorecard' => URL::route('scorecard.save_scorecard')
			];

			JavaScript::put([
				'scorecard_id' => $scorecard->id,
				'package_id' => $sc_data['package']->id,
				'template_id' => $sc_data['template']->id,
				'fixable' => (bool) $sc_data['fixable'],
				'max_score' => Config::get('site.scorecard.max_score'),
				'urls' => $urls
			]);
		}

		if($sc_data['compare']) {
			return View::make('scorecards.data-wrapper', $sc_data)->render();
		}
		else {
			return View::make('scorecards.wrapper', $sc_data);
		}
	}

	/**
	 * viewRankedScorecard
	 * 
	 * Loads data related to ranked scorecards
	 * 
	 * @access public
	 * @param  Scorecard $scorecard
	 * @param  string $type -- what kind of scorecard
	 * @param  array $opts -- any options that we want set should be passed here
	 * @return void
	 */
	public function viewRankedScorecard(Scorecard $scorecard, $type = 'MASTER', array $opts = array())
	{
		$sc_data = RankedScorecard::instance($scorecard->template_id)->build($scorecard, $type, $opts);
		$sc_data = $this->loadDefaults($sc_data);

		$sc_data['scorecard'] = $scorecard;

		if($sc_data['editable']) {
			JavaScript::put([
				'urls' => [
					'save_sort' => URL::route('scorecard.save_sorting'),
					'load_scorecard' => URL::route('scorecard.load_ranked_scorecard'),
					'save_comment' => URL::route('scorecard.save_ranked_comment'),
					'mark_complete' => URL::route('scorecard.save_ranked_scorecard')
				],
				'template_id' => $sc_data['template']->id
			]);
		}

		if($sc_data['compare']) {
			return View::make('scorecards.ranked.data-wrapper', $sc_data)->render();
		}

		return View::make('scorecards.ranked.wrapper', $sc_data);
	}

	/**
	 * scorecardCompare
	 * 
	 * Given a learner scorecard object, load a comparison
	 * 
	 * @access public
	 * @param  Scorecard $learnerScorecard
	 * @return View
	 */
	public function scorecardCompare($learnerScorecard, array $opts = array())
	{
		// load the master scorecard
		$template = $learnerScorecard->template;

		$master = Scorecard::loadMaster($learnerScorecard->package_id, $learnerScorecard->template_id);
		
		$viewOpts = ScorecardBuilder::instance($learnerScorecard->template_id)->build($learnerScorecard);
		$tmp_viewOpts = [
			'comparison' => true,
			'template' => $template,
			'user'=> Auth::user(),
			'compare' => true,
			'pagination' => null,
			'fixable' => false,
			'hide_return_button' => false
		];
		$viewOpts = array_merge($viewOpts, $tmp_viewOpts);
		if(!empty($opts)) {
			$viewOpts = array_merge($viewOpts, $opts);
		}

		// set scorecard options
		// load based on the type
		$scorecard_opts = [
			'compare' => true,
			'show_video' => false,
			'show_header' => true,
			'editable' => false,
		];

		if($template->type == 'R') {
			$masterView = $this->viewRankedScorecard($master, $master->type, $scorecard_opts);
			$learnerView = $this->viewRankedScorecard($learnerScorecard, $learnerScorecard->type, $scorecard_opts);
		}
		else {
			$masterView = $this->viewScorecard($master, $scorecard_opts);
			$learnerView = $this->viewScorecard($learnerScorecard, $scorecard_opts);

			// only provide pagination for standard scorecards
			$availableScorecards = $learnerScorecard->order->scorecard->modelKeys();

			if($viewOpts['pagination'] !== FALSE) {
				$pagination = $this->createSimplePager($availableScorecards, $learnerScorecard->id - 1, $learnerScorecard->id + 1);
				$viewOpts['pagination'] = $pagination;
			}
		}
		
		$viewOpts['show_video'] = true;
		$viewOpts['master'] = $masterView;
		$viewOpts['learner'] = $learnerView;

		return View::make('scorecards.compare-wrapper', $viewOpts);
	}

	/**
	 * loadDefaults
	 * 
	 * Method that loads our default data
	 * 
	 * @access protected
	 * @param  array  $options
	 * @return array
	 */
	protected function loadDefaults(array $options = array())
	{
		$defaults = [
			'compare' => false,
			'show_video' => true,
			'show_header' => true,
			'in_modal' => false
		];

		return array_merge($defaults, $options);
	}

	/**
	 * createSimplePager
	 * 
	 * Method that creates a simple pagination instance for scorecards
	 * 
	 * @access protected
	 * @param  array $items
	 * @param  integer $previous
	 * @param  integer $next    
	 * @return string
	 */
	protected function createSimplePager(array $items, $previous = null, $next = null)
	{
		$previous_link = null;
		$next_link = null;

		if(!empty($previous) && in_array($previous, $items)) {
			$previous_link = URL::route('profile.comparison_scorecard', [$this->user->username, $previous]);
		}

		if(!empty($next) && in_array($next, $items)) {
			$next_link = URL::route('profile.comparison_scorecard', [$this->user->username, $next]);
		}

		return View::make('partials/pagination/simple', [
			'previous_link' => $previous_link,
			'next_link' => $next_link
		])->render();
	}
}
