<?php namespace CSG\Collections;

class OrderCollection extends Collection {

	/**
	 * totalCost
	 * 
	 * Calculate the total cost of the orders
	 * 
	 * @access public
	 * @return string
	 */
	public function totalCost()
	{
		$cost = [];
		foreach($this->items as $order)
		{
			$cost[] = $order->getCost();
		}

		return '$'.number_format(array_sum($cost), 2);
	}
}
