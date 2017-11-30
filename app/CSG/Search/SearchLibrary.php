<?php namespace CSG\Search;

class SearchLibrary
{
	public function users($term)
	{
		return \User::search($term)->get();
	}
}
