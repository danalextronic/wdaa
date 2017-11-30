<?php namespace Admin;

use CSG\Validators\TemplateValidator;
use CSG\Scorecards\Rows as ScorecardRows;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Exception;
use Input;
use JavaScript;
use Package;
use Redirect;
use ScorecardTemplate;
use View;
use Video;

class TemplatesController extends BaseController {

	protected $validator;

	public function __construct(TemplateValidator $validator)
	{
		$this->validator = $validator;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$templates = ScorecardTemplate::with('owner', 'packages')->get();
        
        $this->setupAdminLayout('All Scorecard Templates')->content = View::make('admin.templates.index', compact('templates'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$data = $this->getFormData();

        $this->setupAdminLayout('Create Scorecard Template')->content = View::make('admin.templates.create', $data);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$input = Input::except(
			'_token', 'video_dropdown', 'video_link'
		);

		if(!$this->validator->validate($input, 'form')) {
			return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
		}

		try {
			$template = ScorecardTemplate::manage($input);
			$message = 'Template Created!';

			if($template->type == 'S') {
				$route = 'admin.templates.rows';
				$message .= ' Please create the rows!';
			}
			else {
				$route = 'admin.templates.edit';
			}

			return Redirect::route($route, $template->id)->with('message', $message);
		}
		catch(Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$template = $this->getScorecardTemplate($id);

		if(!$template->items->isEmpty()) {
			$items = $template->filterItemsByType();
		}
		else $items = null;

		$this->setupAdminLayout('View Scorecard Template - ' . $template->name)->content = View::make('admin.templates.show', compact('template', 'items'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
     	$template = $this->getScorecardTemplate($id);
     	$data = $this->getFormData();

     	$data['template'] = $template;
     	$data['current_packages'] = $template->packages->modelKeys();
     	$data['current_videos'] = $template->videos->modelKeys();

     	$this->setupAdminLayout('Edit Scorecard Template - ' . $template->name)->content = View::make('admin.templates.edit', $data);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$template = $this->getScorecardTemplate($id);

		$input = Input::except(
			'_method', '_token', 'video_dropdown', 'video_link'
		);

		if(!$this->validator->validate($input, 'form')) {
			return Redirect::back()->withInput()->withErrors($this->validator->getErrors());
		}

		try {
			$template = ScorecardTemplate::manage($input, $template);

			return Redirect::route('admin.templates.edit', $template->id)->with('message', 'Scorecard Template Saved!');
		}
		catch(Exception $e) {
			return Redirect::back()->withInput()->with('error', $e->getMessage());
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$template = $this->getScorecardTemplate($id);

		$template->delete();

		return Redirect::route('admin.templates.index')->with('message', 'Template Deleted!');
	}

	/**
	 * getTemplateRows
	 * 
	 * Loads a page for managing rows in a template
	 * 
	 * @access public
	 * @return void
	 */
	public function getTemplateRows($id)
	{
		try 
		{
			$data = ScorecardRows::instance($id)->fetchTemplateItems();

			// pass this data to our javascript so we can access it there
			JavaScript::put([
				'use_test_rows' => $data['template']->use_test_rows,
				'use_overall_rows' => $data['template']->use_overall_rows,
				'use_markers' => $data['template']->use_markers,
				'test_rows' => (isset($data['rows']['T'])) ? $data['rows']['T'] : [],
				'overall_rows' => (isset($data['rows']['O'])) ? $data['rows']['O'] : []
			]);

			$this->setupAdminLayout('Edit Rows ' . $data['template']->name)->content = View::make('admin.templates.rows', $data);
		}
		catch(Exception $e)
		{
			return Redirect::route('admin.templates.index')->with('error', $e->getMessage());
		}
	}

	/**
	 * submitTemplateRows
	 * 
	 * POST request for submitting template row data
	 * 
	 * @access public
	 * @return void
	 */
	public function submitTemplateRows($id)
	{
		$rows = Input::get('rows');
		$message = ScorecardRows::instance($id)->save($rows);

		return Redirect::route('admin.templates.rows', $id)->with('message', $message);
	}

	/**
	 * getFormData
	 * 
	 * Method that returns additional data that is needed for the form
	 * 
	 * @access protected
	 * @return array
	 */
	protected function getFormData()
	{
		$packages = Package::all()->lists('name');
		$videos = Video::all(['id', 'name', 'url', 'image_url']);
		$scoring_precision = ScorecardTemplate::$scoring_precision;

		return [
			'packages' => $packages,
			'videos' => $videos,
			'scoring_precision' => $scoring_precision
		];
	}

	/**
	 * getScorecardTemplate
	 * 
	 * @access protected
	 * @param  integer $id
	 * @return object $template
	 * @throws ModelNotFoundException
	 */
	protected function getScorecardTemplate($id)
	{
		try {
			return ScorecardTemplate::findOrFail($id);
		}
		catch(ModelNotFoundException $e) {
			return Redirect::route("admin.templates.index")->with('error', 'Scorecard Template not found!');
		}
	}

}
