<?php

use Illuminate\Database\Migrations\Migration;

class CreateRepoUsersForeignKeys extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create foreign keys for repo_users table

		Schema::table('repo_users', function($table) {
			$table->foreign('repo_id')->references('id')->on('repos');
			$table->foreign('user_id')->references('id')->on('users');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Removes foreign keys on repo_users table

		Schema::table('repo_users', function($table) {
			$table->dropForeign('repo_id');
			$table->dropForeign('user_id');
		});
	}

}