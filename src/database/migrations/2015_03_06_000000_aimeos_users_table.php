<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AimeosUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('salutation', 8);
			$table->string('company', 100);
			$table->string('vatid', 32);
			$table->string('title', 64);
			$table->string('firstname', 64);
			$table->string('lastname', 64);
			$table->string('address1');
			$table->string('address2');
			$table->string('address3');
			$table->string('postal', 16);
			$table->string('city');
			$table->string('state');
			$table->string('langid', 5)->nullable();
			$table->char('countryid', 2)->nullable();
			$table->string('telephone', 32);
			$table->string('telefax');
			$table->string('website');
			$table->date('birthday')->nullable();
			$table->smallInteger('status')->default('1');
			$table->date('vdate')->nullable();
			$table->string('editor');

			$table->index('langid');
			$table->index(array('status', 'lastname', 'firstname'));
			$table->index(array('status', 'address1'));
			$table->index('lastname');
			$table->index('address1');
			$table->index('city');
			$table->index('postal');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropIndex('users_langid_index');
			$table->dropIndex('users_status_lastname_firstname_index');
			$table->dropIndex('users_status_address1_address2_index');
			$table->dropIndex('users_lastname_index');
			$table->dropIndex('users_address1_index');
			$table->dropIndex('users_city_index');
			$table->dropIndex('users_postal_index');

			$table->dropColumn(array(
				'salutation', 'company', 'vatid', 'title', 'firstname',
				'lastname', 'address1', 'address2', 'address3', 'postal', 'city',
				'state', 'langid', 'countryid', 'telephone', 'telefax', 'website',
				'birthday', 'status', 'vdate', 'editor'
			));
		});
	}

}
