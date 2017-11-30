<?php namespace CSG\Collections;

use Illuminate\Database\Eloquent\Collection as BaseCollection;

class Collection extends BaseCollection {

	/**
	 * lists
	 * 
	 * Overriden lists function that simply sets 
	 * a more sensible default for our case
	 * 
	 * @access public
	 * @param  string $name
	 * @param  string $key  
	 * @return array
	 */
	public function lists($name, $key = 'id')
	{
		return parent::lists($name, $key);
	}

	/**
	 * keys
	 * 
	 * Method that sets the keys of the result array
	 * to the name specified. Defaults to ID
	 * 
	 * @access public
	 * @param  string $name
	 * @return Collection
	 */
	public function keys($name = 'id')
	{
		$items = [];

		foreach($this->items as $item)
		{
			if(isset($item->$name)) {
				$items[$item->$name] = $item;
			}
			else {
				$items[] = $item;
			}
		}

		return new static($items);
	}
}
