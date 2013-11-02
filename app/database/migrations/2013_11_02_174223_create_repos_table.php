<?php

use Illuminate\Database\Migrations\Migration;

class CreateReposTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create repos table

		Schema::create('repos', function($table) {
			$table->integer('id', true, true);
			$table->string('name');
			$table->string('language');
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
		// Removes repos table

		Schema::dropIfExists('repos');
	}

}