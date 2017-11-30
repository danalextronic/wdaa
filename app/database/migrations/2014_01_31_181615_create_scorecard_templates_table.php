<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScorecardTemplatesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('scorecard_templates', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id');
			$table->integer('video_id');
			$table->string('name');
			$table->text('description')->nullable();
			$table->string('type', 10);
			$table->string('test_rows_label')->nullable();
			$table->string('overall_rows_label')->nullable();
			$table->boolean('use_test_rows')->default(true);
			$table->boolean('use_overall_rows')->default(true);
			$table->boolean('use_markers')->default(true);
			$table->boolean('use_errors')->default(true);
			$table->boolean('use_coef')->default(true);
			$table->boolean('use_ideas')->default(true);
			$table->boolean('manual_coef')->default(true);
			$table->boolean('use_manual_score');
			$table->decimal('scoring_precision');
			$table->boolean('use_row_comment')->default(true);
			$table->boolean('use_global_comment')->default(true);
			$table->string('state', 10);
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
		Schema::drop('scorecard_templates');
	}

}
