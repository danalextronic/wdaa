<?php namespace CSG\Scorecards;

use Scorecard;
use ScorecardTemplate;
use DB;

class Manager 
{
	/**
	 * name of the pivot table between scorecard templates and videos
	 * 
	 * @var string
	 */
	const SCORECARD_VIDEO_TABLE = 'scorecard_template_video';

	/**
	 * the package that we are assigning the scorecards to
	 * 
	 * @var integer
	 */
	protected $package_id;
	
	/**
	 * an array of the template ids that we are building scorecards for
	 * 
	 * @var array
	 */
	protected $templates;

	/**
	 * gets additional template data
	 * 
	 * @var array
	 */
	protected $template_data;

	/**
	 * Allows for any additional data to be assigned to scorecards
	 * 
	 * @var array
	 */
	protected $additional;

	/**
	 * the instance of our scorecard model
	 * 
	 * @var Scorecard
	 */
	protected $scorecard = null;

	/**
	 * Set up the data needed to manage scorecard records
	 * 
	 * @param int $package_id
	 * @param array $templates
	 * @param array $additional
	 */
	public function __construct($package_id, array $templates, array $additional = array())
	{
		$this->package_id = $package_id;
		$this->templates = $templates;
		$this->additional = $additional;

		$this->template_data = $this->getTemplateTypes();
	}

	/**
	 * Creates scorecard records for the specified
	 * types that are assigned
	 * 
	 * @access public
	 * @return void
	 */
	public function create($scorecard_type = 'MASTER')
	{
		return $this->addRecords($this->templates, $scorecard_type);
	}

	/**
	 * Only keep the templates included in the array and "delete" the others
	 * If you are using Eloquent, make sure that soft deletes are turned on so we can restore
	 * these records later!
	 * 
	 * @access public
	 * @return void
	 */
	public function update()
	{
		// 1. get the current scorecards -- sort by template ID
		$existing_templates = array_keys(Scorecard::wherePackageId($this->package_id)->get()->keys('template_id')->toArray());

		// 2. map each of the new elements to an integer
		// when received from the form, they are all cast as strings
		$new_templates = array_map('intval', $this->templates);

		$items_to_delete = array_diff($existing_templates, $new_templates);

		if(!empty($items_to_delete)) {
			Scorecard::including($this->package_id, $items_to_delete)->delete();
		}

		$items_to_add = array_diff($new_templates, $existing_templates);

		if(!empty($items_to_add)) {
			$this->addRecords($items_to_add);
		}
	}

	/**
	 * gets the type of templates that were passed in
	 * 
	 * @access protected
	 * @return array
	 */
	protected function getTemplateTypes()
	{
		return ScorecardTemplate::whereIn('id', $this->templates)->get(['id', 'type'])->lists('type');
	}

	/**
	 * Top-level method that adds records to our scorecard database
	 * 
	 * @access protected
	 * @param array $templates
	 * @param string $scorecard_type
	 * @return void
	 */
	protected function addRecords(array $templates, $scorecard_type = 'MASTER')
	{
		foreach($templates as $t) 
		{
			if(isset($this->template_data[$t]) && $this->template_data[$t] == 'R') 
			{
				$this->addRankedScorecards($t, $scorecard_type);
			}
			else 
			{
				$this->addScoredScorecard($t, $scorecard_type);
			}
		}
	}

	/**
	 * add the ranked scorecards to the database
	 * 
	 * @access protected
	 * @param  integer $template
	 * @param  string $scorecard_type
	 */
	protected function addRankedScorecards($template, $scorecard_type)
	{
		foreach($this->getVideos($template) as $video_id)
		{
			$this->setupScorecard($template, $scorecard_type, $video_id);
			
			$this->scorecard->video_id = $video_id;

			$this->finalizeScorecard();
		}
	}

	/**
	 * add the scored scorecards to the database
	 * 
	 * @access protected
	 * @param  integer $template
	 * @param  string $scorecard_type
	 */
	protected function addScoredScorecard($template, $scorecard_type)
	{
		$this->setupScorecard($template, $scorecard_type);

		$this->scorecard->video_id = $this->selectVideo($template);

		$this->finalizeScorecard();
	}

	/**
	 * Initialize the scorecard instance variable and setup the initial data
	 * 
	 * @access protected
	 * @param  integer $template
	 * @param  string  $scorecard_type
	 * @param  integer $video_id
	 * @return void
	 */
	protected function setupScorecard($template, $scorecard_type, $video_id = null)
	{
		// get a scorecard record from the database
		// maybe it was trashed -- we will restore it if it has
		// otherwise, create a new model instance
		if(($this->scorecard = $this->find($template, $scorecard_type, $video_id)) === FALSE)  
		{
			$this->scorecard = new Scorecard;
		}

		$this->scorecard->package_id = $this->package_id;
		$this->scorecard->template_id = $template;
		$this->scorecard->type = $scorecard_type;
	}

	/**
	 * Set any additional data and save our model to the database
	 * 
	 * @access protected
	 * @return void
	 */
	protected function finalizeScorecard()
	{
		// if there are additional fields passed in,
		// we will want to set those here
		if(!empty($this->additional)) 
		{
			foreach($this->additional as $key => $value)
			{
				$this->scorecard->$key = $value;
			}
		}

		$this->scorecard->save();
	}

	/**
	 * Checks to see if a scorecard record exists (even if it was trashed)
	 * 
	 * @access protected
	 * @param  numeric $template      
	 * @param  string $scorecard_type
	 * @param  integer $video_id
	 * @return Scorecard | boolean
	 */
	protected function find($template, $scorecard_type, $video_id = null)
	{
		$order_id = (isset($this->additional['order_id'])) ? $this->additional['order_id'] : false;

		$scorecard = Scorecard::withTrashed()->where(function($query) use($template, $scorecard_type, $video_id, $order_id)
		{
			$query->where('package_id', $this->package_id);
			$query->where('template_id', $template);
			$query->where('type', $scorecard_type);

			if(!is_null($video_id)) {
				$query->where('video_id', $video_id);
			}

			if($order_id) {
				$query->where('order_id', $order_id);
			}

		})->first();

		if($scorecard) 
		{
			// restore it if it was trashed
			if($scorecard->trashed()) 
			{
				$scorecard->restore();
			}

			return $scorecard;
		}

		return false;
	}

	/**
	 * Returns an array of video IDs assigned to this template
	 * 
	 * @access protected
	 * @param  integer $template_id
	 * @return array      
	 */
	protected function getVideos($template_id)
	{
		return DB::table(static::SCORECARD_VIDEO_TABLE)
			->join('videos', 'video_id', '=', 'videos.id')
			->where('template_id', $template_id)
			->lists('video_id');
	}

	/**
	 * Select a random video that is assigned to our template
	 * This is used for scored scorecards ONLY
	 * 
	 * @access protected
	 * @param  integer $template_id
	 * @return integer $video_id
	 */
	protected function selectVideo($template_id)
	{
		$video = DB::table(static::SCORECARD_VIDEO_TABLE)
			->where('template_id', $template_id)
			->orderBy('video_id', DB::raw('RAND()'))
			->first();

		return $video->id;
	}
}
