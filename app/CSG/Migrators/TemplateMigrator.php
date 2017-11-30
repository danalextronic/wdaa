<?php namespace CSG\Migrators;

class TemplateMigrator extends BaseMigrator
{
	public function migrate()
	{
		// get all scorecard templates
		$templates = $this->old->table('scorecard_templates')->get();

		foreach($templates as $template)
		{
			$video_id = $this->createVideo($template->sct_video_id);

			$template_id = $this->createTemplate($template, $video_id);

			$this->createTemplateItems($template_id);
		}

		return true;
	}

	public function createVideo($id)
	{
		$video = $this->old->table('videos')->where('video_id', $id)->first();

		// setup data for adding record to DB
		$data = [
			'user_id' => $video->video_user_id,
			'name' => $video->video_name,
			'url' => $video->video_url,
			'image_url' => $video->video_image_url,
			'extension' => ($video->video_extension) ?: 'mp4',
			'filesize' => ($video->video_filesize) ?: 0
		];

		$model = \Video::create($data);

		return $model->id;
	}

	public function createTemplate($template, $video_id)
	{
		$data = [
			'user_id' => $template->sct_user_id,
			'video_id' => $video_id,
			'name' => $template->sct_name,
			'description' => $template->sct_description,
			'type' => $template->sct_type,
			'test_rows_label' => $template->sct_test_rows_label,
			'overall_rows_label' => $template->sct_overall_rows_label,
			'use_test_rows' => $template->sct_use_test_rows,
			'use_overall_rows' => $template->sct_use_overall_rows,
			'use_markers' => $template->sct_use_markers,
			'use_errors' => $template->sct_use_errors,
			'use_ideas' => $template->sct_use_ideas,
			'manual_coef' => $template->sct_manual_coef,
			'use_manual_score' => $template->sct_use_manual_score,
			'scoring_precision' => $template->sct_scoring_precision,
			'use_row_comment' => $template->sct_use_row_comment,
			'use_global_comment' => $template->sct_use_global_comment
		];

		$model = \ScorecardTemplate::create($data);

		return $model->id;
	}

	public function createTemplateItems($template_id)
	{
		$templateItems = $this->old->table('scorecard_template_items')->where('scti_sct_id', $template_id)->get();

		foreach($templateItems as $item)
		{
			$old_id = $item->scti_id;

			$data = [
				'template_id' => $item->scti_sct_id,
				'order' => $item->scti_order,
				'text' => $item->scti_text,
				'ideas' => $item->scti_ideas,
				'coef' => $item->scti_coef,
				'type' => $item->scti_type
			];

			$model = \ScorecardTemplateItem::create($data);

			$item_id = $model->id;

			$this->createTemplateMarkers($old_id, $item_id);
		}
	}

	public function createTemplateMarkers($old_item_id, $new_item_id)
	{
		$templateMarkers = $this->old->table('scorecard_template_markers')->where('marker_scti_id', $old_item_id)->get();

		foreach($templateMarkers as $marker)
		{
			$data = [
				'item_id' => $new_item_id,
				'name' => $marker->marker_name,
				'text' => $marker->marker_text,
				'order' => $marker->marker_order
			];

			\ScorecardTemplateMarkers::create($data);
		}
	}
}
