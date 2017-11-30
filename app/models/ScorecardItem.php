<?php

class ScorecardItem extends BaseModel
{
	protected $guarded = [];


	// ==================================================================
	//
	// Model Relationships
	//
	// ------------------------------------------------------------------
	

	public function scorecard()
	{
		return $this->belongsTo('Scorecard', 'scorecard_id');
	}

	public function template_item()
	{
		return $this->belongsTo('ScorecardTemplateItem', 'template_item_id');
	}

	// ==================================================================
	//
	// Model Methods
	//
	// ------------------------------------------------------------------
	
	public function syncTemplate(ScorecardTemplateItem $item)
	{
		$changed = false;

		if($item->coef != $this->coef) {
			$this->coef = $item->coef;
			$changed = true;
		}

		// TODO: perform additional checks here
		
		// if the data changed, save a copy to the database
		if($changed) {
			$this->save();
		}
	}

	/**
	 * isComplete
	 * 
	 * Method that checks to see if the row is complete
	 * 
	 * @access public
	 * @param  ScorecardTemplate $template
	 * @return boolean                    
	 */
	public function isComplete(ScorecardTemplate $template)
	{
		if($template->use_manual_score == 0) 
		{
			return (!empty($this->points) && !empty($this->comments));
		}

		return !empty($this->comments);
	}

	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------
	
	/**
	 * saveRow
	 * 
	 * Method that takes an array of item data
	 * and updates it in the database
	 * 
	 * @access public
	 * @param  array  $data
	 * @return ScorecardItem
	 * @static
	 */
	public static function saveRow(array $data)
	{
		// item_id, column, value
		extract($data);

		$item = static::find($item_id);

		if(is_null($item)) {
			throw new Exception("Item not found!");
		}

		$item->$column = $value;

		$item->save();

		return $item;
	}
}
