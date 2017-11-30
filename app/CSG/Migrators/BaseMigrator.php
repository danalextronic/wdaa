<?php namespace CSG\Migrators;

abstract class BaseMigrator {

	protected $old;
	protected $new;

	public function __construct()
	{
		$this->old = \DB::connection('old');
		$this->new = \DB::connection('mysql');
	}

	abstract public function migrate();
}
