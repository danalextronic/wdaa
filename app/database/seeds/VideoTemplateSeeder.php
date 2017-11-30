<?php

class VideoTemplateSeeder extends Seeder {

	public function run()
	{
		DB::table('scorecard_template_video')->truncate();
		
		// get the video ids assigned to scorecard templates
		$templates = ScorecardTemplate::lists('video_id', 'id');

		foreach($templates as $template_id => $video_id)
		{
			DB::table('scorecard_template_video')->insert([
				'template_id' => $template_id,
				'video_id' => $video_id
			]);
		}
	}
}
