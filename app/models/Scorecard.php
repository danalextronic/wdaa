<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use CSG\Scorecards\Manager as ScorecardManager;
use CSG\Collections\ScorecardCollection;

class Scorecard extends BaseModel {
	protected $softDelete = true;

	// ==================================================================
	//
	// Model Relationships
	//
	// ------------------------------------------------------------------
	
	public function items()
	{
		return $this->hasMany('ScorecardItem');
	}

	public function order()
	{
		return $this->belongsTo('Order');
	}

	public function owner()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function package()
	{
		return $this->belongsTo('Package');
	}

	public function template()
	{
		return $this->belongsTo('ScorecardTemplate', 'template_id');
	}

	public function video()
	{
		return $this->belongsTo('Video');
	}

	// ==================================================================
	//
	// Query Scopes
	//
	// ------------------------------------------------------------------
	
	/**
	 * scopeIncluding
	 * 
	 * Method that includes templates from the query
	 * If an array is passed, we will execute a "WHERE IN" query
	 * 
	 * @access public
	 * @param  object $query
	 * @param  integer $package_id
	 * @param  integer|array $templates 
	 * @return void
	 */
	public function scopeIncluding($query, $package_id = null, $templates)
	{
		if($package_id) {
			$query->where('package_id', $package_id);
		}

		if($templates) {
			if(is_array($templates)) {
				$query->whereIn('template_id', $templates);
			}
			else {
				$query->where('template_id', $templates);
			}
		}
	}

	/**
	 * scopeByType
	 * 
	 * Method that filters scorecards by type
	 * 
	 * @access public
	 * @param  object $query
	 * @param  string $type
	 * @return object      
	 */
	public function scopeByType($query, $type)
	{
		return $query->where('type', strtoupper($type));
	}

	/**
	 * scopeFilterType
	 * 
	 * @access public
	 * @param  object $query
	 * @param  string $type
	 * @param  integer $user_id
	 * @param  integer $order_id
	 * @return object
	 */
	public function scopeFilterType($query, $type, $user_id, $order_id)
	{
		$this->scopeByType($query, $type);

		if($type == 'LEARNER') {
			$query->where('order_id', $order_id);
			$query->where('user_id', $user_id);
		}
	}

	/**
	 * scopeSortRanked
	 * 
	 * Order scorecards for ranked displays
	 * 
	 * @access public
	 * @param  object $query
	 * @return void
	 */
	public function scopeSortRanked($query)
	{
		// sort scores by numeric first, then NULL
		$query->orderBy(DB::raw('score is null'));
		$query->orderBy('score', 'asc');
	}

	// ==================================================================
	//
	// Model Methods
	//
	// ------------------------------------------------------------------
	
	/**
	 * sets the starting date for the scorecard
	 * 
	 * @access public
	 * @return void
	 */
	public function setStartDate()
	{
		if(empty($this->started_at)) {
			$this->started_at = new DateTime;
			$this->save();
		}
	}

	/**
	 * setScore
	 * 
	 * Updates the score for the current record
	 * 
	 * @access public
	 * @param float $score
	 * @param float $max_score
	 */
	public function setScore($score, $max_score = null)
	{
		$this->score = $score;

		if(!is_null($max_score)) {
			$this->max_score = $max_score;
		}

		$this->save();
	}

	/**
	 * setComment
	 * 
	 * Method that sets the global comment in the database
	 * 
	 * @access public
	 * @param  string $text
	 */
	public function setComment($text)
	{
		$this->global_comment = $text;

		$this->save();
	}

	/**
	 * saveComment
	 * 
	 * Alias for this::setComment()
	 * 
	 * @access public
	 * @param  string $text
	 * @return void
	 */
	public function saveComment($text)
	{
		return $this->setComment($text);
	}

	/**
	 * method that marks our scorecard as complete
	 * 
	 * @access public
	 * 
	 * @return string
	 */
	public function markComplete($redirect = true)
	{
		$this->complete = true;
		$this->completed_at = new DateTime;

		$this->save();

		return ($redirect) ? $this->buildRedirect() : true;
	}

	/**
	 * builds a redirection route for our scorecards
	 * 
	 * @access public
	 * @return string
	 */
	public function buildRedirect()
	{
		if($this->type == 'MASTER') {
			return URL::route('master.dashboard');
		}

		return URL::route('profile', $this->owner->username);
	}

	public function newCollection(array $models = array())
    {
        return new ScorecardCollection($models);
    }

	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------
		
	/**
	 * createLearner
	 * 
	 * Method that creates learner scorecard records
	 * 
	 * @access public
	 * @param  OrderCollection  $items
	 * @param  User   $user 
	 * @return void
	 */
	public static function createLearner($items, User $user)
	{
		foreach($items as $item) 
		{
			// get the templates in the package
			try {
				$package = Package::findOrFail($item->package_id);
				$templates = $package->getTemplateIds();
			}
			catch(ModelNotFoundException $e) {
				return false;
			}

			// use the scorecard manager class to create
			// scorecard records
			$args = [
				'order_id' => $item->order_id,
				'user_id' => $user->id
			];

			$manager = new ScorecardManager($item->package_id, $templates, $args);

			if(!$manager->create('LEARNER')) {
				return false;
			}
		}
	}

	/**
	 * loadMaster
	 * 
	 * Loads a master scorecard by the template ID
	 * 
	 * @access public
	 * @param  interger $package_id
	 * @param  integer  $template_id
	 * @return Scorecard
	 * @static
	 */
	public static function loadMaster($package_id, $template_id = null)
	{
		$method = (is_null($template_id)) ? 'get' : 'first';

		return static::where(function($q) use($package_id, $template_id) {
			$q->where('type', 'MASTER');
			$q->where('package_id', $package_id);

			if(!empty($template_id)) {
				$q->where('template_id', $template_id);
			}
		})->$method();
	}
}
