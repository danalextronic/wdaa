<?php

use Carbon\Carbon;

class ScorecardVerification extends BaseModel {

	const INCOMPLETE_TAB = 'incomplete';
	const PENDING_TAB = 'pending';
	const SATISFIED_TAB = 'satisfactory';
	const UNSATISFIED_TAB = 'unsatisfactory';

	public static $tabs = [
		self::INCOMPLETE_TAB, 
		self::PENDING_TAB, 
		self::SATISFIED_TAB,
		self::UNSATISFIED_TAB
	];

	protected $guarded = [];

	protected $softDelete = true;

	// ==================================================================
	//
	// Model Relationships
	//
	// ------------------------------------------------------------------

	public function order()
	{
		return $this->belongsTo('Order', 'order_id');
	}

	public function owner()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function verifyer()
	{
		return $this->belongsTo('User', 'verified_user_id');
	}

	// ==================================================================
	//
	// Model Methods
	//
	// ------------------------------------------------------------------


	/**
	 * updateData
	 *
	 * Updates the record with our new input
	 *
	 * @access public
	 * @param  $input
	 * @return void
	 */
	public function updateData($input)
	{
		$this->comment = $input['comment'];
		$this->satisfactory = $input['satisfactory'];

		$this->save();
	}
	
	public function completedVerification( ){
		$this->completed = 1;
		$this->save();
	}
	
	/**
	 * verifies the current record
	 *
	 * @access public
	 * @param User $user
	 * @return void
	 */
	public function addVerification(User $user)
	{
		$this->verified = 1;
		$this->verified_user_id = $user->id;

		$this->save();
	}

	/**
	 * canEdit
	 *
	 * Method that checks to see if the current record is editable
	 *
	 * @access public
	 * @return boolean
	 */
	public function canEdit()
	{
		$current_user = Auth::user();

		// if the current user is an admin or a reviewer, they can always edit
		if($current_user->isAdmin() || $current_user->belongsToRole('review', false)) {
			return true;
		}

		// the evaluator must own the post that they want to edit
		if($current_user->belongsToRole('evaluate', false) && $current_user->id == $this->user_id) {
			return true;
		}

		return false;
	}

	/**
	 * canDelete
	 *
	 * Alias for canEdit functionality
	 *
	 * @access public
	 * @return boolean
	 */
	public function canDelete()
	{
		return $this->canEdit();
	}

	/**
	 * canVerify
	 *
	 * Method that checks to see if the current user
	 * has permissions to verify this record
	 *
	 * @access public
	 * @return boolean
	 */
	public function canVerify()
	{
		$current_user = Auth::user();

		// if the current user is an admin they can always verify
		if($current_user->isAdmin()) {
			return true;
		}

		if($current_user->belongsToRole('review', false)) {
			return true;
		}

		return false;
	}

	/**
	 * verified
	 *
	 * Checks to see if a record is verified
	 *
	 * @access public
	 * @return boolean
	 */
	public function verified()
	{
		return ($this->verified == 1);
	}


	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------

	/**
	 * verify
	 *
	 * Method that saves the data to the database and determines
	 * the types of email that we need to send out
	 *
	 * @access public
	 * @param  array  $input
	 * @param  Order  $order
	 * @return array
	 * @static
	 */
	public static function verify(array $input, Order $order)
	{
		return static::create([
			'order_id' => $order->id,
			'comment' => $input['comment'],
			'satisfactory' => $input['satisfactory'],
			'verified' => 0
		]);
	}

	/**
	 * buildConditional
	 *
	 * @access public
	 * @param  string $tabName
	 * @return string
	 */
	public static function buildConditional($tabName)
	{
		$whereClause = null;

		if($tabName == self::PENDING_TAB) {
			$whereClause = " AND verified = 0";
		}
		elseif($tabName == self::SATISFIED_TAB || $tabName == self::UNSATISFIED_TAB) {
			$whereClause = " AND verified = 1";
			if($tabName == self::SATISFIED_TAB) {
				$whereClause .= " AND satisfactory = 1";
			}
			else {
				$whereClause .= " AND satisfactory = 0";
			}
		}
		
		$baseQuery = "SELECT COUNT(*) FROM scorecard_verifications WHERE order_id = orders.id {$whereClause} LIMIT 1";
		$conditional = null;

		switch($tabName) {
			case self::INCOMPLETE_TAB:
				$conditional = "($baseQuery) = 0";
				break;
			case self::PENDING_TAB:
			case self::SATISFIED_TAB:
			case self::UNSATISFIED_TAB:
				$conditional = "($baseQuery) > 0";
				break;
			default:
				throw new Exception("Invalid Tab: {$tabName}");
		}

		return $conditional;
	}
}
