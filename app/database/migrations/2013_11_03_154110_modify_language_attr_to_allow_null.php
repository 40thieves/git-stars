<?php

use Illuminate\Database\Migrations\Migration;

class ModifyLanguageAttrToAllowNull extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		// Modify language attribute on repos table to allow null values

		DB::update('ALTER TABLE repos MODIFY COLUMN language VARCHAR(255)'); // Laravel doesn't seem to have capability to alter existing attr to allow null
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		// Modify language attribute on repos table to NOT NULL

		DB::update('ALTER TABLE repos MODIFY COLUMN language VARCHAR(255) NOT NULL'); // Laravel doesn't have capability to set column not null
	}

}