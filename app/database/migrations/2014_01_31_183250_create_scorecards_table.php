<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScorecardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scorecards', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('package_id');
			$table->integer('template_id');
			$table->integer('user_id')->nullable();
			$table->integer('order_id')->nullable();
			$table->decimal('score', 5, 2)->nullable();
			$table->decimal('max_score', 5, 2)->nullable();
			$table->text('global_comment')->nullable();
			$table->string('state')->default('I');
			$table->enum('type', array('MASTER', 'LEARNER'));
			$table->timestamps();
			$table->timestamp('date_started');
			$table->timestamp('date_completed');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('scorecards');
	}

}
