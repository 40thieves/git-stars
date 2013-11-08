<?php

use Illuminate\Database\Migrations\Migration;

class UpdateReposTableWithUrls extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Add urls attribute to repos table
		Schema::table('repos', function($table) {
			$table
				->string('url')
				->nullable()
				->after('language')
				;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Remove urls attribute from repos table
		Schema::table('repos', function($table) {
			$table->dropColumn('url');
		});
	}

}