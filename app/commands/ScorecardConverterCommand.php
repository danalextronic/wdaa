<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ScorecardConverterCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'copy:scorecards';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Convert scorecards from one installation to the other.';


	protected $lib;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lib = new CSG\Migrators\ScorecardMigrator();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$this->lib->migrate();
		
		// if($this->lib->migrate())
		// {
		// 	$this->info('Migration completed!');
		// }
		// else
		// {
		// 	$this->error('we encountered an error.');
		// }
	}
}
