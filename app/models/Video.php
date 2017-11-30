<?php

class Video extends BaseModel {
	protected $softDelete = true;

	protected $guarded = [];

	/**
	 * a video can have many templates
	 * 
	 * @access public
	 * @return void
	 */
	public function templates()
	{
		return $this->belongsToMany('ScorecardTemplate', 'scorecard_template_video', 'template_id', 'video_id');
	}

	/**
	 * a user owns a template
	 * 
	 * @access public
	 * @return void
	 */
	public function owner()
	{
		return $this->belongsTo('User', 'user_id');
	}

	public function scorecards()
	{
		return $this->hasMany('Scorecard');
	}

	/**
	 * imageUrl
	 * 
	 * Method that gets the image URL
	 * 
	 * @access public
	 * @param  string $url Video URL
	 * @return string      Image URL
	 */
	public function imageUrl($url)
	{
		$type = (strpos($url, 'youtube') !== false) ? 'youtube' : 'upload';

		if($type == 'youtube') {
			$id = $this->getYoutubeId($url);
			$url = sprintf(Config::get('video.youtube_image_url'), $id);
		}
		else {
			$image_url = Config::get('video.upload_image_url').basename($url);
			$url = str_replace(Config::get('video.video_key'), Config::get('video.image_key'), $image_url);
			$url = str_replace(pathinfo($url, PATHINFO_EXTENSION), Config::get('video.image_ext'), $url);
		}

		return $url;
	}

	/**
	 * get_youtube_id
	 * 
	 * Given a URL, parse out a youtube ID
	 * 
	 * @access private
	 * @param  string $url
	 * @return string - Youtube ID or full URL if no youtube URL
	 */
	private function getYoutubeId($url)
	{
		if(strpos($url, 'youtube') === false) {
			return $url;
		}

		$utquery = parse_url($url, PHP_URL_QUERY);
		$ut_vid_id = "";

		if(strpos($utquery, "&") !== false) {
		    $ut_vid_id = explode("&", $utquery);
		    $ut_vid_id = explode("=", $ut_vid_id[0]);
		    $ut_vid_id = $ut_vid_id[1];
		} else {
		    $ut_vid_id = explode("=",$utquery);				
		    $ut_vid_id = $ut_vid_id[1];
		}

		return $ut_vid_id;
	}

	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------
		
	/**
	 * insertVideo
	 * 
	 * Method that handles the insertion of video
	 * into the database
	 * 
	 * @access public
	 * @param  string  $url
	 * @param  boolean $user_id
	 * @param  boolean $title  
	 * @return integer
	 * @static
	 * @throws Exception
	 */
	public static function insertVideo($url, $user_id = false, $name = false)
	{
		$user_id = ($user_id) ?: Auth::user()->id;

		$default_name = basename($url);

		$video = new static([
			'user_id' => $user_id,
			'url' => $url,
			'name' => $default_name,
			'filesize' => @filesize($url)
		]);

		// collect the file extension if its not a youtube video
		if(strpos($url, 'youtube') === false) {
			$video->extension = pathinfo($url, PATHINFO_EXTENSION);
		}

		$video->image_url = $video->imageUrl($url);

		// if title was provided, use it and generate the video slug
		if(!empty($name)) {
			$video->name = $name;
		}

		if($video->save()) {
			return $video->id;
		}

		throw new Exception("There was a problem saving the video");
	}
}
