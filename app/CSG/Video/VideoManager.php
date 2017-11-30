<?php namespace CSG\Video;

use Video;

class VideoManager {

	/**
	 * check
	 * 
	 * Method for checking our video URL and making sure that it is valid
	 * @param  string $url
	 * @return integer
	 * @throws Exception
	 */
	public function check($url)
	{
		if(!valid_url($url)) 
		{
			throw new Exception("Please provide a valid url.");
		}

		if(!$this->validVideoUrl($url)) 
		{
			throw new Exception("This video is not available.");
		}

		$video = Video::whereUrl($url)->orderBy('created_at', 'desc')->first();

		if(empty($video))
		{
			$id = Video::insertVideo($url);
		}
		else
		{
			$id = $video->id;
		}

		return $id;
	}

	/**
	 * validVideoUrl
	 * 
	 * Method that contains a valid video URL
	 * 
	 * @access public
	 * @param  string $url
	 * @return boolean
	 */
	public function validVideoUrl($url)
	{
		$headers = get_headers($url, 1);
		$response = current($headers);

		// if we have no headers or we don't have a 200 header, it is invalid
		if($headers === false || strpos($response,'200') === false) 
		{
			return false;
		}

		// if this is a youtube video and it exists, move on
		if(strpos($url, 'youtube') !== false) 
		{
			return true;
		}

		// if we don't have a video content type, bail out
		if(strpos($headers['Content-Type'], 'video') === false) 
		{
			return false;
		}

		return true;	
	}
}
