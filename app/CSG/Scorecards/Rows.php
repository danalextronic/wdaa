<?php namespace CSG\Scorecards;

use CSG\Validators\TemplateValidator;

use Config;
use Exception;
use Scorecard;
use ScorecardItem;
use ScorecardTemplate;
use ScorecardTemplateItem;
use ScorecardTemplateMarkers;
use User;


class Rows {

	protected $template;
	protected $template_items;
	protected $items;

	public static $checklist_labels = [
		'rows' => 'Scorecard Rows',
		'comment' => 'Overall Remarks',
		'manual_score' => 'Final Score',
	];

	protected static $instances = [];

	/**
	 * instance
	 * 
	 * Method for Creating objects quickly
	 * Only have one instance per template ID
	 * 
	 * @access public
	 * @param  integer $template_id
	 * @return CSG\Scorecards\Rows
	 * @static
	 */
	public static function instance($template_id)
	{
		if(!isset(static::$instances[$template_id])) {
			static::$instances[$template_id] = new static($template_id);
		}

		return static::$instances[$template_id];
	}

	/**
	 * __construct
	 * 
	 * Sets instance variables and pulls in data
	 * from the datasource
	 * 
	 * @access public
	 * @param  integer $id
	 */
	public function __construct($template_id, TemplateValidator $validation = null)
	{
		$this->template_id = $template_id;
		$this->validation = ($validation) ?: \App::make('CSG\\Validators\\TemplateValidator');

		$this->setupData($template_id);
	}

	/**
	 * fetchTemplateItems
	 * 
	 * Method for parsing our template items from our database results
	 * 
	 * @access public
	 * @return array
	 */
	public function fetchTemplateItems()
	{
		$rows = [];

		if(!empty($this->template_items)) {
			$rows = $this->buildRowArray();
		}

		return [
			'template' => $this->template,
			'rows' => $rows
		];
	}

	/**
	 * getTemplate
	 * 
	 * Gets our template data
	 * 
	 * @return array
	 */
	public function getTemplate()
	{
		return $this->template;
	}

	/**
	 * gets our item data
	 * 
	 * 
	 * @return array
	 */
	public function getItems()
	{
		return $this->items;
	}

	/**
	 * save
	 * 
	 * method for saving rows to the database
	 * 
	 * @access public
	 * @param  array  $data
	 * @return void
	 */
	public function save(array $data)
	{
		// merge the test and overall rows together
		$rows = $this->parseRows($data);

		if(empty($rows))
		{
			// delete all rows assigned to this template ID
			ScorecardTemplateItem::deleteBy($this->template_id, 'template_id');

			return 'Scorecard Rows Saved!';
		}

		// loop through the rows
		$order = 0;
		$itemIds = [];
		$update = false;

		foreach($rows as $row)
		{
			$order++;

			if(isset($row->id) && !empty($row->id))
			{
				$update = true;
			}

			$row->order = $order;
			$itemId = ScorecardTemplateItem::manage($row, $this->template_id, $this->template_items);
			$itemIds[] = $itemId;

			if(isset($row->markers) && count($row->markers) > 0)
			{
				$this->manageRowMarkers($row->markers, $itemId);
			}
		}

		if($update)
		{
			$this->syncItems($itemIds, $this->template_id);
		}

		return 'Scorecard Rows Saved!';
	}

	/**
	 * build
	 * 
	 * Method that builds the client facing scorecard
	 * 
	 * @access public
	 * @param  Scorecard $scorecard
	 * @param boolean $sort_by_type - if TRUE, sorts scorecard items by template type (T|O)
	 * @return void
	 */
	public function build(Scorecard $scorecard, $sort_by_type = true)
	{
		// get package
		$package = $scorecard->package;

		// Get scorecard template
		$template = $this->template;

		// get video
		$video = $scorecard->video;

		// get user
		$user = $this->loadUser($scorecard->user_id, $scorecard->type);

		// Get scorecard items
		$items = $this->items = $scorecard->items->keys('template_item_id');

		// Get template items
		$template_items = $this->template_items;

		// load order
		$order = $order = ($this->hasOrder($scorecard->order_id, $scorecard->type)) ? $scorecard->order : null;

		$row_items = $this->manageItems($template_items, $items, $scorecard, $sort_by_type);

		$scorecard->setStartDate();

		return [
			'scorecard' => $scorecard,
			'package' => $package,
			'video' => $video,
			'template' => $template,
			'items' => $row_items,
			'user' => $user,
			'order' => $order
		];
	}

	/**
	 * calculateScore
	 * 
	 * Method that calculates the scorecard's score
	 * 
	 * @access public
	 * @param  Scorecard $scorecard
	 * @param  boolean $save - if TRUE, we will update the data in our database
	 * @return array
	 */
	public function calculateScore(Scorecard $scorecard, $save = false)
	{
		// get scorecard details
		// don't sort the scorecard rows since this
		// will make it much harder to calculate the score
		$sc = $this->sc = (object) $this->build($scorecard, false);

		$score = $sc->scorecard->score;

		// Unscored.
		if($sc->template->use_manual_score == 0 && $sc->template->use_overall_rows == 0 && $sc->template->use_test_rows == 0) {
			return [
				'score' => 0,
				'max_score' => 0,
			];
		}

		if(count($sc->items) == 0) {
			return [
				'score' => $score,
				'max_score' => (int) Config::get('site.scorecard.max_score')
			];
		}

		$score = 0;
		$max_score = 0;
		$incomplete = [];
		foreach($sc->items as $row) {

			// Skip over rows that are disabled in our template.
			if(($row['template_item']['type'] == 'T' && $sc->template->use_test_rows == 0) ||
			   ($row['template_item']['type'] == 'O' && $sc->template->use_overall_rows == 0)
			){
				continue;
			}

			// Calculated scoring, so we'll add things up as we loop through.
			// We still need to loop through on manual scoring to check that the comment is filled out.
			if($sc->template->use_manual_score == 0) {
				$error = ($sc->template->use_errors == 1) ? $row['item']['errors'] : 0;

				if($sc->template->use_coef == 1) {
					$coef = ($row['item']['coef'] && $sc->template->manual_coef == 1) ? $row['item']['coef'] : $row['template_item']['coef'];
				} else $coef = 1;

				if(empty($row['item']['points']) || empty($row['item']['comments'])) {
					$incomplete[] = (int)$row['item']['id'];
				}

				$points = ($row['item']['points'] * $coef) - ($error*$coef);

				$max_score = $max_score +  (10*$coef);
				$score = $score + $points;
			}
			else {
				if(empty($row['item']['comments'])) {
					$incomplete[] = (int)$row['item']['id'];
				}
			}
		}

		// Reset the manual score if it's set.
		if($sc->template->use_manual_score == 1) {
			$max_score = (int) Config::get('site.scorecard.max_score');
		}

		// Save on the fly
		if($save) {
			$scorecard->setScore($score, $max_score);
		}

		return [
			'score' => $score,
			'max_score' => $max_score,
			'incomplete' => $incomplete,
		];
	}

	/**
	 * checkProgress
	 * 
	 * Check the progress of our scorecard object
	 * Does not calculate scoring or anything like that
	 * 
	 * @access public
	 * @param  Scorecard $scorecard
	 * @param  [type]    $score    
	 * @return [type]              
	 */
	public function checkProgress(Scorecard $scorecard, $score)
	{
		if(!isset($this->sc)) {
			// build scorecard if not already built
			$this->sc = (object) $this->build($scorecard, false);
		}

		$template = $this->sc->template;
		$comment = $this->sc->scorecard->global_comment;
		$manual_score = $this->sc->scorecard->score;

		$is_ranked = ($template->type == 'R');

		$checklist = [];

		// do we have scorecard rows?
		if(($template->use_test_rows == 1 || $template->use_overall_rows == 1) && count($this->sc->items) > 0 && !$is_ranked) {
			$checklist['rows'] = (isset($score['incomplete']) && count($score['incomplete']) == 0);
		}

		// do we have global comment?
		if($template->use_global_comment == 1) {
			$checklist['comment'] = (!empty($comment));
		}

		if($template->use_manual_score == 1 && !$is_ranked) {
			$checklist['manual_score'] = ($manual_score != '0.00');
		}

		if($is_ranked && isset($this->sc->scorecard)) {
			$checklist['drag_and_drop'] = ($this->sc->scorecard->started_at != $this->sc->scorecard->updated_at);
		}

		return $checklist;
	}

	/**
	 * setupData
	 * 
	 * Method for retrieving and setting template data from the data source
	 * 
	 * @access protected
	 * @param  integer $id
	 * @return object
	 * @throws Exception
	 */
	protected function setupData($template_id)
	{
		$template = ScorecardTemplate::find($template_id);

		if(is_null($template)) {
			throw new Exception("Scorecard Template not found!");
		}

		if($template->type != 'S') {
			throw new Exception("This scorecard template does not allow for rows!");
		}

		$this->template = $template;

		// get template items -- and eager load markers
		$this->template_items = ScorecardTemplateItem::with('markers')->byTemplate($template_id)->get()->keys('id');
	}

	/**
	 * buildRowArray
	 * 
	 * Method for building an array for displaying template items
	 * and rows
	 * 
	 * @access protected
	 * @return array
	 */
	protected function buildRowArray()
	{
		$rows = [];
		foreach($this->template_items as $item) {
			$rowItem = [
				'id' => $item->id,
				'coef' => $item->coef,
				'text' => $item->text,
				'ideas' => $item->ideas,
			];

			if($this->template->use_markers && $item->markers) {
				$marker = [];
				foreach($item->markers as $index => $m) {
					$marker["testrows_#index#_markers"][] = [
						'name' => $m->name,
						'text' => $m->text,
						'id' => $m->id
					];
				}

				$rowItem = array_merge($rowItem, $marker);
				unset($marker);
			}

			$rows[$item->type][] = $rowItem;
		}

		return $rows;
	}

	/**
	 * parseRows
	 * 
	 * Function that parses template rows and returns them
	 * 
	 * Original Format: ['T' => [...], 'O' => ['...']]
	 * New Format: [object, object, object]
	 * 
	 * @access protected
	 * @param  array  $rows
	 * @return array
	 */
	protected function parseRows(array $rows)
	{
		$return = [];
		foreach($rows as $type => $items)
		{
			foreach($items as $item)
			{
				$item = (object) $item;

				$item->type = $type;

				$return[] = $item;
			}
		}

		return $return;
	}

	/**
	 * manageRowMarkers
	 * 
	 * Manages row markers in the database
	 * 
	 * @access protected
	 * @param  array  $markers
	 * @param  integer $item_id
	 * @return void
	 */
	protected function manageRowMarkers(array $markers, $item_id)
	{
		$order = 0;
		$ids = [];
		$updated = false;

		// get the current markers that are assigned to this template
		$current_markers = $this->template_items[$item_id]->markers->keys('id');

		foreach($markers as $marker)
		{
			$order++;
			$marker = (object) $marker;

			$updated = (isset($marker->id) && !empty($marker->id));

			$marker->order = $order;

			$ids[] = ScorecardTemplateMarkers::manage($marker, $item_id, $current_markers);

		}

		if($updated)
		{
			// sync markers in the database
			// ie, remove the ones that we no longer need
			$this->syncMarkers($ids, $item_id);
		}
	}

	/**
	 * syncMarkers
	 * 
	 * Ensures that we only have the necessary markers in the database
	 * 
	 * @access protected
	 * @param  array  $markerIds
	 * @param  integer $item_id  
	 * @return void          
	 */
	protected function syncMarkers(array $markerIds, $item_id)
	{
		ScorecardTemplateMarkers::excluding($markerIds, $item_id)->delete();
	}

	/**
	 * syncItems
	 * 
	 * Deletes the items that we no longer need in the database
	 * 
	 * @access protected
	 * @param  $array $itemIds
	 * @param  integer $template_id
	 * @return void            
	 */
	protected function syncItems(array $itemIds, $template_id)
	{
		ScorecardTemplateItem::excluding($itemIds, $template_id)->delete();
	}

	/**
	 * manageItems
	 * 
	 * Method that manages our scorecard items
	 * 
	 * @access protected
	 * @param  object    $template_items
	 * @param  object    $items         
	 * @param  Scorecard $scorecard
	 * @return void
	 */
	protected function manageItems($template_items, $items, Scorecard $scorecard, $sort_by_type)
	{
		$rows = [];
		foreach($template_items as $key => $item)
		{
			if(!isset($items[$key])) {
				// create new item
				$new_item = ScorecardItem::create([
					'scorecard_id' => $scorecard->id,
					'template_item_id' => $item->id,
					'coef' => $item->coef
				]);
			}
			elseif(!$scorecard->complete) {
				// sync up with the template if the data changed
				$items[$key]->syncTemplate($item);
			}

			$data = [
				'template_item' => $item,
				'item' => isset($items[$key]) ? $items[$key] : $new_item,
				'markers' => $item->markers
			];

			if($sort_by_type) {
				$rows[$item->type][$key] = $data;
			}
			else {
				$rows[$key] = $data;
			}
		}

		return $rows;
	}

	/**
	 * Loads a user for the given scorecard
	 * 
	 * @access protected
	 * @param  integer $user_id
	 * @param  string  $type   
	 * @return User | false
	 */
	protected function loadUser($user_id, $type)
	{
		return ($user_id && $type == 'LEARNER') ? User::getUser($user_id, 'id') : false;
	}

	/**
	 * Checks to see if there is an order assigned to the scorecard record
	 * 
	 * @access protected
	 * @param  integer $order_id
	 * @param  string $type    
	 * @return boolean
	 */
	protected function hasOrder($order_id, $type)
	{
		return (!empty($order_id) && $type == 'LEARNER');
	}
}
