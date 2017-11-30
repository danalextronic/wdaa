<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScorecardItemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scorecard_items', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('scorecard_id');
			$table->integer('template_item_id');
			$table->decimal('points')->nullable();
			$table->integer('errors')->default(0);
			$table->decimal('coef')->default(1.00);
			$table->text('comments')->nullable();
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('scorecard_items');
	}

}
