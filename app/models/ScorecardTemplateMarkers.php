<?php

class ScorecardTemplateMarkers extends BaseModel
{
	public $timestamps = false;

	protected $table = 'scorecard_template_markers';

	protected $guarded = [];

	/**
	 * a marker belongs to a template item
	 */
	public function item()
	{
		return $this->belongsTo('ScorecardTemplateItem', 'item_id');
	}

	public function scopeExcluding($query, $marker_ids, $item_id)
	{
		$query->where('item_id', $item_id);
		$query->whereNotIn('id', $marker_ids);
	}

	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------
	
	public static function manage($marker, $item_id, $current_markers = null)
	{
		if(!empty($marker->id) && $current_markers->has($marker->id))
		{
			$instance = $current_markers[$marker->id];
		}
		else
		{
			$instance = new self;
		}

		$instance->item_id = $item_id;

		$instance->name = $marker->name;
		$instance->text = $marker->text;
		$instance->order = $marker->order;

		$instance->save();

		return $instance->id;
	}
}
