<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnalyticsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('analytics', function(Blueprint $table) {
			$table->increments('id');
			$table->string('user_id');
			$table->string('referrel');
			$table->string('current_page');
			$table->string('ip_address', 20);
			$table->string('browser');
			$table->string('operating_system');
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
		Schema::drop('analytics');
	}

}
