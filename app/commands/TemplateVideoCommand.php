<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TemplateVideoCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'scorecards:video';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Migrate videos from scorecard template to the individual scorecard record';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		// get all templates (eager load videos)
		$templates = ScorecardTemplate::with('videos')->get();

		// get all learner scorecards
		$scorecards = Scorecard::whereType('LEARNER')->get();

		foreach($templates as $t) 
		{
			// get the video
			$video = $t->videos->first();

			// filter the scorecards so we only have the ones
			// that are assigned to the current template
			$items = $this->filterScorecardsByTemplate($scorecards, $t->id)->keys('id');
			$ids = array_keys($items->toArray());

			Scorecard::whereIn('id', $ids)->update(['video_id' => $video->id]);
		}

		$this->info('Scorecard videos converted!');
	}

	/**
	 * filterScorecardsByTemplate
	 * 
	 * Method that filters our scorecards by a given template
	 * 
	 * @access protected
	 * @param  Collection $scorecards
	 * @param  integer $template_id
	 * @return Collection
	 */
	protected function filterScorecardsByTemplate($scorecards, $template_id)
	{
		return $scorecards->filter(function($sc) use($template_id) {
			return $sc->template_id == $template_id;
		});
	}
}
