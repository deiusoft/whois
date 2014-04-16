<?php

class Create_Domains_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create
		(
			'domains',
			function($table)
			{
				$table->string('name', 77)->primary();
				$table->timestamps();
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
		Schema::drop('domains');
	}

}