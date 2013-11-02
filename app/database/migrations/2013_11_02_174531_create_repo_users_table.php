<?php

use Illuminate\Database\Migrations\Migration;

class CreateRepoUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Create repo_users table

		Schema::create('repo_users', function($table) {
			$table->integer('id', true, true);
			$table->integer('repo_id', false, true);
			$table->integer('user_id', false, true);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Remove repo_users table

		Schema::dropIfExists('repo_users');
	}

}