<?php

use Illuminate\Database\Migrations\Migration;

class RenameRepoUsersToStars extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Rename repo_users to stars

		Schema::rename('repo_users', 'stars');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Rename stars to repo_users

		Schema::rename('stars', 'repo_users');
	}

}