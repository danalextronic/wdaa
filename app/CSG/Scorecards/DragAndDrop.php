<?php namespace CSG\Scorecards;

use Scorecard;
use CSG\Collections\ScorecardCollection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DragAndDrop extends Rows {

	/**
	 * $template_id
	 * 
	 * The template on the current instance
	 * 
	 * @var integer
	 * @access protected
	 */
	protected $template_id;

	/**
	 * __construct
	 * 
	 * Set the template ID
	 * 
	 * @access public
	 * @param  integer $template_id
	 */
	public function __construct($template_id)
	{
		$this->template_id = $template_id;
	}

	/**
	 * build
	 * 
	 * Gets the data for a ranked scorecard
	 * 
	 * @access public
	 * @return void
	 */
	public function build(Scorecard $scorecard, $type = 'MASTER', array $opts = array())
	{
		// get the scorecards assigned
		$scorecards = Scorecard::with('video')
			->whereTemplateId($this->template_id)
			->filterType($type, $scorecard->user_id, $scorecard->order_id)
			->sortRanked()
			->get();

		$user = $this->loadUser($scorecard->user_id,  $scorecard->type);
		$order = ($this->hasOrder($scorecard->order_id, $scorecard->type)) ? $scorecard->order : null;

		$completed = $this->isComplete($scorecards);
		$can_mark_complete = $this->canMarkComplete($scorecards);

		$editable  = ($scorecard->type == 'MASTER' || ($scorecard->type == 'LEARNER' && !$completed));

		return array_merge([
			'scorecards' => $scorecards,
			'template' => $scorecard->template,
			'user' => $user,
			'order' => $order,
			'completed' => $completed,
			'can_mark_complete' => $can_mark_complete,
			'editable' => $editable
		], $opts);
	}

	/**
	 * sort
	 * 
	 * Save the sorted scorecard ids
	 * 
	 * @access public
	 * @param  array  $scorecard_ids
	 * @return void
	 */
	public function sort(array $scorecard_ids)
	{
		// get the current scorecards
		$scorecards = Scorecard::whereIn('id', $scorecard_ids)->get()->keys();

		foreach($scorecard_ids as $index => $id)
		{
			if(!$scorecards->has($id)) continue;

			// get the model instance -- set the data -- and move on
			$scorecard = $scorecards->get($id);

			$scorecard->setScore($index + 1);
		}
	}

	/**
	 * save
	 * 
	 * Save the global comment related to scorecards
	 * 
	 * @access public
	 * @param  array  $data
	 * @return void
	 */
	public function save(array $data)
	{
		try {
			$scorecard = Scorecard::findOrFail($data['scorecard_id']);
		}
		catch(ModelNotFoundException $e) {
			throw new Exception("Scorecard not found!");
		}

		$scorecard->saveComment($data['global_comment']);

		return $this->build($scorecard, $scorecard->type);
	}

	/**
	 * canMarkComplete
	 * 
	 * Well, can we mark them as complete?
	 * 
	 * @param  ScorecardCollection $scorecards
	 * @return boolean
	 */
	protected function canMarkComplete(ScorecardCollection $scorecards)
	{
		$completed = $scorecards->filter(function($sc) {
			return !empty($sc->global_comment);
		});

		return $scorecards->count() === $completed->count();
	}

	/**
	 * isComplete
	 * 
	 * Checks to see if our ranked scorecards are completed
	 * 
	 * @access public
	 * @param  ScorecardCollection $scorecards
	 * @return boolean                        
	 */
	protected function isComplete(ScorecardCollection $scorecards)
	{
		$completed = $scorecards->filter(function($sc) {
			return ($sc->complete == 1);
		});

		return $scorecards->count() === $completed->count();
	}
}
