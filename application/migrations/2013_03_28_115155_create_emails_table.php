<?php

class Create_Emails_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create
		(
			'emails',
			function($table)
			{
				$table->increments('id');
				$table->string('email', 128)->unique();
				$table->string('image_code', 512);
			}
		);
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('emails');
	}

}