<?php

class ScorecardTemplate extends BaseModel {

	protected $softDelete = true;

	protected $table = 'scorecard_templates';

	protected $guarded = [];

	public static $scoring_precision = [
		'1' => 'Whole Numbers',
		'.5' => 'Half Numbers (i.e. 8.5)',
		'.25' => 'Quarter Numbers (i.e. 8.25)',
		'.1' => 'Tenths (i.e. 8.1)',
	];


	// ==================================================================
	//
	// Relationship definitions
	//
	// ------------------------------------------------------------------
	

	/**
	 * a scorecard template has many template items
	 * @return void
	 */
	public function items()
	{
		return $this->hasMany('ScorecardTemplateItem', 'template_id');
	}

	/**
	 * a user can own a scorecard template
	 * @return void
	 */
	public function owner()
	{
		return $this->belongsTo('User', 'user_id');
	}

	/**
	 * a scorecard template can belong to many packages
	 * @return mixed
	 */
	public function packages()
	{
		return $this->belongsToMany('Package');
	}

	/**
	 * a scorecard template can have many videos assigned to it
	 * 
	 * @access public
	 * @return void
	 */
	public function videos()
	{
		return $this->belongsToMany('Video', 'scorecard_template_video', 'template_id', 'video_id');
	}

	// ==================================================================
	//
	// Model Methods
	//
	// ------------------------------------------------------------------
	
	/**
	 * filterItemsByType
	 * 
	 * Filters the template items by type
	 * 
	 * @access public
	 * @return array
	 */
	public function filterItemsByType()
	{
		$items = $this->items;

		$test = $this->filterRows($items, 'T');
		$overall = $this->filterRows($items, 'O');

		return [
			'T' => $test,
			'O' => $overall
		];
	}

	/**
	 * markComplete
	 * 
	 * Method that marks a collection of scorecards as complete
	 * 
	 * @access public
	 * @param  object $scorecards
	 * @return void
	 */
	public function markComplete($scorecards)
	{
		foreach($scorecards as $scorecard)
		{
			$scorecard->markComplete(false);
		}
	}

	/**
	 * filterRows
	 * 
	 * Filters the items by the specified type
	 * 
	 * @access private
	 * @param  Collection $items
	 * @param  string $type 
	 * @return Collection       
	 */
	private function filterRows($items, $type)
	{
		return $items->filter(function($item) use($type) {
			return $item->type == $type;
		});
	}

	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------
	
	/**
	 * manage
	 * 
	 * Method for managing our scorecard templates
	 * 
	 * @access public
	 * @param  array $input
	 * @param  ScorecardTemplate $template
	 * @return ScorecardTemplate
	 * @static
	 * @throws Exception
	 */
	public static function manage($input, ScorecardTemplate $template = null)
	{
		if(is_null($template)) {
			$template = new static;
			$action =  'create';
		}
		else {
			$action = 'update';
		}

		$packages = static::checkFor('packages', $input);
		$videos = static::checkFor('videos', $input);

		foreach($input as $name => $value) {
			$template->$name = $value;
		}

		$template->save();

		static::updateContent($template, $action, $packages, 'packages');
		static::updateContent($template, $action, $videos, 'videos');

		return $template;
	}

	/**
	 * checkFor
	 * 
	 * Checks to see if the data exists in the input
	 * 
	 * @access private
	 * @param  string $type
	 * @param  array $input
	 * @return mixed
	 */
	private static function checkFor($type, &$input)
	{
		$items = null;
		if(isset($input[$type])) {
			$items = $input[$type];
			unset($input[$type]);
		}

		return $items;
	}

	/**
	 * updateContent
	 * 
	 * Updates our content with our pivot tables
	 * 
	 * @access private
	 * @param  ScorecardTemplate $template
	 * @param  string $action  
	 * @param  array $items   
	 * @param  string $type    
	 * @return void
	 * @static
	 */
	private static function updateContent(ScorecardTemplate $template, $action, $items = null, $type = null)
	{
		if(!is_null($items)) {
			if($action == 'create') {
				$template->$type()->attach($items);
			}
			else {
				$template->$type()->sync($items);
			}
		}
	}
	
}
