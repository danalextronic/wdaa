<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class PivotPackageScorecardTemplateTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('package_scorecard_template', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('package_id')->unsigned()->index();
			$table->integer('scorecard_template_id')->unsigned()->index();
			$table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
			$table->foreign('scorecard_template_id')->references('id')->on('scorecard_templates')->onDelete('cascade');
		});
	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('package_scorecard_template');
	}

}
