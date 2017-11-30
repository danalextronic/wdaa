<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScorecardTemplateMarkersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scorecard_template_markers', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('item_id', 10)->unsigned();
			$table->string('name');
			$table->string('text');
			$table->integer('order');

			$table->foreign('item_id')->references('id')->on('scorecard_template_items')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('scorecard_template_markers');
	}

}
