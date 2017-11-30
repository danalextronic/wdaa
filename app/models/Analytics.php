<?php

class Analytics extends BaseModel {

	protected $table = 'analytics';

	protected $guarded = [];


	// ==================================================================
	//
	// Model Relationships
	//
	// ------------------------------------------------------------------
	
	/**
	 * an analytic belongs to a user
	 * 
	 * @return void
	 */
	public function user()
	{
		return $this->belongsTo('User');
	}


	// ==================================================================
	//
	// Static Methods
	//
	// ------------------------------------------------------------------
	

	/**
	 * record
	 * 
	 * Method that records an analytics request to the database
	 * 
	 * @access public
	 * @param  object $request
	 * @param  object $response
	 * @return Analytics
	 */
	public static function record($request, $response)
	{
		$browser = Agent::browser() . ' ' . Agent::version(Agent::browser());
		$os = Agent::platform() . ' ' . Agent::version(Agent::platform());

		return static::create([
			'referrel' => URL::previous(),
			'current_page' => implode("/", $request->segments()),
			'ip_address' => Request::getClientIp(),
			'browser' => $browser,
			'operating_system' => $os
		]);
	}
}
