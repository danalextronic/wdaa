<?php namespace CSG\Collections;

class ScorecardCollection extends Collection {

	/**
	 * filterBy
	 * 
	 * Method that filters items by complete/incomplete
	 * 
	 * @access public
	 * @param  string $name
	 * @return Collection
	 */
	public function filterBy($name)
	{
		$complete = ($name == 'complete') ? true : false;

		$template = null;

		$newItems = $this->filter(function($item) use($complete, &$template) {
			if(empty($template)) {
				$template = $item->template;
			}

			return $item->complete == $complete;
		});

		if($template->type == 'R') {
			$newItems = $this->filterRanked($newItems);
		}

		return $newItems;
	}

	/**
	 * filterRanked
	 * 
	 * filter the items for ranked templates
	 * 
	 * @access public
	 * @param  Collection $newItems
	 * @return Collection          
	 */
	public function filterRanked($newItems = null)
	{
		$items = [];
		$names = [];

		$newItems = (!is_null($newItems)) ? $newItems : $this->items;

		foreach($newItems as $key => $item)
		{
			if(!in_array($item->template->name, $names)) {
				$names[] = $item->template->name;
				$items[$key] = $item;
			}
		}

		return new static($items);
	}

	/**
	 * calculateScore
	 * 
	 * Adds final score to the calculated array
	 * 
	 * @access public
	 * @return array
	 */
	public function getScoreData()
	{
		$scores = [];

		foreach($this->items as $item) {
			$scores[$item->template_id] = (object) [
				'score' => $item->score,
				'max_score' => $item->max_score,
				'final_score' => $this->final_score($item)
			];
		}

		return $scores;
	}

	/**
	 * final_score
	 * 
	 * Calculate the final score
	 * 
	 * @access protected
	 * @param  object $item
	 * @return float      
	 */
	protected function final_score($item)
	{
		return number_format(($item->score / $item->max_score) * 100, 2) . '%';
	}
}
