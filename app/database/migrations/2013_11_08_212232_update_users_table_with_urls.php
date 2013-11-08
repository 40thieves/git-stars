<?php

use Illuminate\Database\Migrations\Migration;

class UpdateUsersTableWithUrls extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Adds urls attribute to users table
		Schema::table('users', function($table) {
			$table
				->string('url')
				->nullable()
				->after('username')
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
		// Remove urls attribute from users table
		Schema::table('users', function($table) {
			$table->dropColumn('url');
		});
	}

}