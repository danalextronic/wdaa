<?php namespace CSG\Helpers;

class States {

	/**
	 * fetchBy
	 * 
	 * Method that receives the appropriate list
	 * of states for the given country
	 * 
	 * @access public
	 * @param  string $country
	 * @return array
	 * @static
	 */
	public static function fetchBy($country)
	{
		$results = [];

		if(empty($country)) {
			return static::$states;
		}

		switch(strtolower($country)) {
			case 'us':
				$results = static::$states;
				break;
			case 'ca':
				$results = static::$ca_provinces;
				break;
			case 'au':
				$results = static::$au_provinces;
				break;
		}

		return $results;	
	}

	public static $states = [
	 "AL" => "Alabama",  
	 "AK" => "Alaska",  
	 "AZ" => "Arizona",  
	 "AR" => "Arkansas",  
	 "CA" => "California",  
	 "CO" => "Colorado",  
	 "CT" => "Connecticut",  
	 "DE" => "Delaware",  
	 "DC" => "District Of Columbia",  
	 "FL" => "Florida",  
	 "GA" => "Georgia",  
	 "HI" => "Hawaii",  
	 "ID" => "Idaho",  
	 "IL" => "Illinois",  
	 "IN" => "Indiana",  
	 "IA" => "Iowa",  
	 "KS" => "Kansas",  
	 "KY" => "Kentucky",  
	 "LA" => "Louisiana",  
	 "ME" => "Maine",  
	 "MD" => "Maryland",  
	 "MA" => "Massachusetts",  
	 "MI" => "Michigan",  
	 "MN" => "Minnesota",  
	 "MS" => "Mississippi",  
	 "MO" => "Missouri",  
	 "MT" => "Montana",
	 "NE" => "Nebraska",
	 "NV" => "Nevada",
	 "NH" => "New Hampshire",
	 "NJ" => "New Jersey",
	 "NM" => "New Mexico",
	 "NY" => "New York",
	 "NC" => "North Carolina",
	 "ND" => "North Dakota",
	 "OH" => "Ohio",  
	 "OK" => "Oklahoma",  
	 "OR" => "Oregon",  
	 "PA" => "Pennsylvania",  
	 "RI" => "Rhode Island",  
	 "SC" => "South Carolina",  
	 "SD" => "South Dakota",
	 "TN" => "Tennessee",  
	 "TX" => "Texas",  
	 "UT" => "Utah",  
	 "VT" => "Vermont",  
	 "VA" => "Virginia",  
	 "WA" => "Washington",  
	 "WV" => "West Virginia",  
	 "WI" => "Wisconsin",  
	 "WY" => "Wyoming"
	];

	public static $ca_provinces = [
		"BC"=>"British Columbia", 
	    "ON"=>"Ontario", 
	    "NL"=>"Newfoundland and Labrador", 
	    "NS"=>"Nova Scotia", 
	    "PE"=>"Prince Edward Island", 
	    "NB"=>"New Brunswick", 
	    "QC"=>"Quebec", 
	    "MB"=>"Manitoba", 
	    "SK"=>"Saskatchewan", 
	    "AB"=>"Alberta", 
	    "NT"=>"Northwest Territories", 
	    "NU"=>"Nunavut",
	    "YT"=>"Yukon Territory"
	];

	public static $au_provinces = [
		"NSW"=>"New South Wales",
	    "VIC"=>"Victoria",
	    "QLD"=>"Queensland",
	    "TAS"=>"Tasmania",
	    "SA"=>"South Australia",
	    "WA"=>"Western Australia",
	    "NT"=>"Northern Territory",
	    "ACT"=>"Australian Capital Terrirory"
	];
}
