<?php namespace CSG\Migrators;

use PDO;

class ScorecardMigrator extends BaseMigrator {

	const SCORECARD_TABLE_NAME = 'scorecards';
	const SCORECARD_ITEMS_TABLE_NAME = 'scorecard_items';

	/**
	 * migrate
	 * 
	 * Method for migrating our scorecard data
	 * 
	 * @access public
	 * @return boolean
	 */
	public function migrate()
	{
		$old_scorecards = $this->old->table(self::SCORECARD_TABLE_NAME)->where('scorecard_type', 'MASTER')->get();
		$new_scorecards = $this->new->table(self::SCORECARD_TABLE_NAME)->where('type', 'MASTER')->get();

		foreach($old_scorecards as $key => $old)
		{
		 	$this->updateScorecard($old, $new_scorecards[$key]);
		}

		$this->updateItems();

		return true;
	}

	/**
	 * updateScorecard
	 * 
	 * Method that updates scorecards
	 * 
	 * @access public
	 * @param  object $old
	 * @param  object $new
	 * @return void
	 */
	protected function updateScorecard($old, $new)
	{
		$data = [
			'score' => $old->scorecard_score,
			'max_score' => $old->scorecard_max_score,
			'global_comment' => strip_tags($old->scorecard_global_comment)
		];

		$this->new->table(self::SCORECARD_TABLE_NAME)->where(function($q) use ($new) {
			$q->where('template_id', $new->template_id);
			$q->where('type', $new->type);
		})->update($data);
	}

	/**
	 * updateItems
	 * 
	 * Update the custom scorecard items
	 * 
	 * @access protected
	 * @param  integer $old_id
	 * @param  integer $new_id
	 * @return void
	 */
	protected function updateItems()
	{
		$old_items = $this->old->getPdo()->query(
			"SELECT ti.scti_type, i.* FROM tbl_scorecard_items i
			join tbl_scorecard_template_items ti ON i.sci_scti_id = scti_id
			WHERE i.sci_scorecard_id IN(
				SELECT scorecard_id FROM tbl_scorecards WHERE scorecard_type = 'MASTER' ORDER BY scorecard_template_id ASC
			)
			ORDER BY i.sci_scorecard_id ASC, ti.scti_order ASC"
		)->fetchAll(PDO::FETCH_OBJ);

		$new_items = $this->new->getPdo()->query(
			"SELECT ti.type, i.* FROM scorecard_items i
			join scorecard_template_items ti ON i.template_item_id = ti.id
			WHERE i.scorecard_id IN(
				SELECT id FROM scorecards WHERE type = 'MASTER' ORDER BY template_id ASC
			)
			ORDER BY i.scorecard_id ASC, ti.order ASC
		")->fetchAll(PDO::FETCH_OBJ);

		foreach($old_items as $key => $old)
		{
			$this->updateItem($old, $new_items[$key]);
		}
	}

	/**
	 * updateItem
	 * 
	 * Method that updates an item inside of the database
	 * 
	 * @access protected
	 * @param  object $old
	 * @param  object $new
	 * @return void
	 */
	protected function updateItem($old, $new)
	{
		$data = [
			'points' => $old->sci_points,
			'errors' => $old->sci_errors,
			'coef' => $old->sci_coef,
			'comments' => $old->sci_comments,
		];

		$this->new->table(self::SCORECARD_ITEMS_TABLE_NAME)->where('id', $new->id)->update($data);
	}
}
