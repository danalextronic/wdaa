<?php namespace CSG\Scorecards;

use CSG\Collections\ScorecardCollection;
use Order;
use Scorecard;
use ScorecardTemplate;
use ScorecardVerification;
use User;

class Verification {

	protected $roles = [
		'evaluate', 'review'
	];

	/**
	 * get
	 * 
	 * Gets the scores for our scorecard verification
	 * 
	 * @access public
	 * @param  Order  $order
	 * @return void
	 */
	public function get(Order $order)
	{
		$template = $order->package->templates->first();

		$learner_scorecards = $order->scorecard;
		$learner_scorecards = $this->isRanked($learner_scorecards, $template);

		$master_scorecards = Scorecard::loadMaster($order->package_id);
		$master_scorecards = $this->isRanked($master_scorecards, $template);

		$template_names = $this->getTemplateNames($learner_scorecards);

		if($template->type != 'R') {
			// scored
			$learner = $learner_scorecards->getScoreData();
			$master = $master_scorecards->getScoreData();
		}
		else {
			// drag and drop
			$learner = $learner_scorecards->keys('template_id');
			$master = $master_scorecards->keys('template_id');
		}

		return [
			'scorecards' => $learner_scorecards,
			'templates' => $template_names,
			'template_type' => $template->type,
			'learner' => $learner,
			'master' => $master,
		];
	}

	/**
	 * canAccess
	 * 
	 * Checks to see if the provided user can access the order
	 * 
	 * @access public
	 * @param  Order  $order
	 * @param  User   $user 
	 * @return array roles
	 */
	public function canAccess(Order $order, User $user)
	{
		$roles = $this->getUserRoles($user);

		if(!in_array(true, $roles)) {
			return false;
		}

		return $roles;
	}

	/**
	 * verify
	 * 
	 * Method that handles the verification process
	 * 
	 * @access public
	 * @param  ScorecardVerification $comment
	 * @param  User                  $user   
	 * @return void
	 */
	public function verify(ScorecardVerification $comment, User $user)
	{
		$comment->addVerification($user);
	}
	
	
	public function completed(ScorecardVerification $comment, User $user ){
		$comment->completedVerification($user);
	}

	/**
	 * getTemplateNames
	 * 
	 * Method that gets the necessary template names
	 * 
	 * @access protected
	 * @param  ScorecardCollection $scorecards
	 * @return array
	 */
	protected function getTemplateNames(ScorecardCollection $scorecards)
	{
		$names = [];

		$scorecards->load('template');

		foreach($scorecards as $scorecard)
		{
			$names[$scorecard->template_id] = $scorecard->template->name;
		}

		return $names;
	}

	/**
	 * get the permissions for the provided user
	 * 
	 * @access protected
	 * @param  User   $user
	 * @return array
	 */
	protected function getUserRoles(User $user)
	{
		$current_roles = array_map('strtolower', array_pluck($user->roles->toArray(), 'name'));
		$available_roles = array_intersect($current_roles, $this->roles);

		// people who can validate review can also evaluate as well
		$can_evaluate = (in_array('evaluate', $available_roles) || in_array('review', $available_roles)) || $user->isAdmin();
		$can_review = (in_array('review', $available_roles)) || $user->isAdmin();

		return [$can_evaluate, $can_review];
	}

	/**
	 * is the provided template drag and drop? if so, filter down the scorecards
	 * 
	 * @access protected
	 * @param  ScorecardCollection $scorecards
	 * @param  ScorecardTemplate   $template  
	 * @return boolean                        
	 */
	protected function isRanked(ScorecardCollection $scorecards, ScorecardTemplate $template)
	{
		if($template->type == 'R') {
			return $scorecards->filterRanked();
		}

		return $scorecards;
	}
}
