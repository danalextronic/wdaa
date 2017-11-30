<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class TemplatesCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'copy:templates';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Copies scorecard templates from our old app to our new app.';

	protected $lib;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();

		$this->lib = new CSG\Migrators\TemplateMigrator();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		if($this->lib->migrate())
		{
			$this->info('Migration completed!');
		}
		else
		{
			$this->error('we encountered an error.');
		}
	}
}
