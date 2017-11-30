<?php

class ScorecardTemplateItem extends BaseModel
{
	protected $table = 'scorecard_template_items';

	protected $guarded = [];

	// ==================================================================
	//
	// Model Relationships
	//
	// ------------------------------------------------------------------
	

	/**
	 * markers
	 * 
	 * A template items can have many markers
	 * 
	 * @access public
	 * @return void
	 */
	public function markers()
	{
		return $this->hasMany('ScorecardTemplateMarkers', 'item_id');
	}

	/**
	 * a template item belongs to a template
	 * 
	 * @access public
	 * @return void
	 */
	public function template()
	{
		return $this->belongsTo('ScorecardTemplate', 'template_id');
	}

	// ==================================================================
	//
	// Query scopes
	//
	// ------------------------------------------------------------------
	

	/**
	 * scopeByTemplate
	 * 
	 * where template id is provided value
	 * 
	 * @access public
	 * @param  object $query
	 * @param  integer $template_id
	 */
	public function scopeByTemplate($query, $template_id)
	{
		$query->where('template_id', $template_id);
	}

	public function scopeExcluding($query, $itemIds, $template_id)
	{
		$query->where('template_id', $template_id);
		$query->whereNotIn('id', $itemIds);
	}

	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------
		
	/**
	 * deleteBy
	 * 
	 * Delete items in the table by a given key
	 * 
	 * @access public
	 * @param  integer $id
	 * @param  string $type
	 * @return void
	 */
	public static function deleteBy($id, $type = 'template_id')
	{
		return static::where($type, $id)->delete();
	}

	/**
	 * manage
	 * 
	 * Manage the current item and determine if it
	 * needs to be updated or created in our database
	 * 
	 * @access public
	 * @param  object $item
	 * @param  integer $template_id  
	 * @param  Collection $current_items
	 * @return integer
	 */
	public static function manage($item, $template_id, $current_items = null)
	{
		// check and see if an item with a corresponding
		// ID exists in our current items and pull the
		// model instance from there
		if(!empty($item->id) && $current_items->has($item->id))
		{
			$instance = $current_items[$item->id];
		}
		else
		{
			// otherwise, we will create a new one
			$instance = new self;
		}

		$instance->template_id = $template_id;
		$instance->order = $item->order;
		$instance->text = $item->text;
		$instance->ideas = $item->ideas;
		$instance->coef = $item->coef;
		$instance->type = $item->type;

		// save to the database and return the ID

		$instance->save();

		return $instance->id;
	}
}
