<?php

use CSG\Collections\Collection as MyCollection;

class BaseModel extends Eloquent {

	/**
	 * Get the table associated with the model.
	 *
	 * @return string
	 */
	public function getTable()
	{
		if (isset($this->table)) return $this->table;

		return $this->table = str_replace('\\', '', snake_case(str_plural(class_basename($this))));
	}

	/**
	 * getAllColumnNames
	 * 
	 * Helper that gets all column names based on the database type
	 * @return [type] [description]
	 */
	public function getAllColumnsNames()
    {
        switch (DB::connection()->getConfig('driver')) {
            case 'pgsql':
                $query = "SELECT column_name FROM information_schema.columns WHERE table_name = '".$this->table."'";
                $column_name = 'column_name';
                $reverse = true;
                break;

            case 'mysql':
                $query = 'SHOW COLUMNS FROM '.$this->table;
                $column_name = 'Field';
                $reverse = false;
                break;

            case 'sqlsrv':
                $parts = explode('.', $this->table);
                $num = (count($parts) - 1);
                $table = $parts[$num];
                $query = "SELECT column_name FROM ".DB::connection()->getConfig('database').".INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'".$table."'";
                $column_name = 'column_name';
                $reverse = false;
                break;

            default: 
                $error = 'Database driver not supported: '.DB::connection()->getConfig('driver');
                throw new Exception($error);
                break;
        }

        $columns = array();

        foreach(DB::select($query) as $column)
        {
            $columns[] = $column->$column_name;
        }

        if($reverse)
        {
            $columns = array_reverse($columns);
        }

        return $columns;
    }

	/**
	 * boot
	 * 
	 * Method that binds any events to our models
	 * 
	 * @access protected
	 * @return void
	 */
	protected static function boot()
	{
		parent::boot();

		static::creating(function($model) {
			User::addUserTo($model);
		});
	}
	
	/**
	 * newCollection
	 * 
	 * Overriden method to define our own
	 * custom collection library
	 * 
	 * @access public
	 * @param  array  $models
	 * @return CSG\Collections\Collection
	 */
	public function newCollection(array $models = array())
	{
		return new MyCollection($models);
	}

	/**
	 * scopeOwner
	 * 
	 * Method that adds a WHERE clause for a user ID
	 * 
	 * @access public
	 * @param  object $query
	 * @param  integer $user_id
	 * @return void
	 */
	public function scopeOwner($query, $user_id)
	{
		return $query->where('user_id', $user_id);
	}

	public function scopeRecent($query, $field = 'updated_at')
	{
		return $query->orderBy($field, 'desc');
	}
		
	/**
	 * priceFormat
	 * 
	 * Returns a formatted price
	 * Call from child accessor methods that show a price
	 * 
	 * @access protected
	 * @param  string $value
	 * @return string
	 */
	protected function priceFormat($value)
	{
		return '$' . $value;
	}

	/**
	 * removePriceFormat
	 * 
	 * Removes our price formatting from our string
	 * Call from child model mutator methods
	 * 
	 * @access protected
	 * @param  string $value
	 * @return string       
	 */
	protected function removePriceFormat($value)
	{
		return str_replace('$', '', $value);
	}

	/**
	 * hasColumn
	 * 
	 * Method that checks to see if a column exists in the database
	 * 
	 * @access protected
	 * @param  string  $name
	 * @return boolean      
	 */
	protected function hasColumn($name)
	{
		$columns = $this->getAllColumnsNames();

		return in_array($name, $columns);
	}

}
