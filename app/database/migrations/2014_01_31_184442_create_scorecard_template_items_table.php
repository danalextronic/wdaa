<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScorecardTemplateItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scorecard_template_items', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('template_id', 10)->unsigned();
			$table->integer('order')->nullable();
			$table->mediumtext('text')->nullable();
			$table->mediumtext('ideas')->nullable();
			$table->decimal('coef')->default(1.00);
			$table->enum('type', array('T', 'O'));
			$table->timestamps();

			$table->foreign('template_id')->references('id')->on('scorecard_templates')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('scorecard_template_items');
	}

}
