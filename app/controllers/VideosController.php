<?php

use CSG\Exceptions\AjaxException;
use CSG\Video\VideoManager;

class VideosController extends BaseController {

	public function __construct(VideoManager $video)
	{
		$this->video = $video;
	}

	/**
	 * checkVideo
	 * 
	 * AJAX method that checks to see if our video URL is in the database
	 * If it is, retrieve the ID and return it
	 * Otherwise, create a new record and return it
	 * 
	 * @access public
	 * @return json
	 */
	public function checkVideo()
	{
		try
		{
			$id = $this->video->check(Input::get('url'));

			return jsonResponse(true, "Video Found", [
				'video_id' => $id
			]);
		}
		catch(Exception $e)
		{
			throw new AjaxException($e->getMessage());
		}
	}

	public function videoPlayer($video)
	{
		$video = Video::retrieve($video)->get();
	}
}
