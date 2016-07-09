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
			$table->string('salutation', 8)->default('');
			$table->string('company', 100)->default('');
			$table->string('vatid', 32)->default('');
			$table->string('title', 64)->default('');
			$table->string('firstname', 64)->default('');
			$table->string('lastname', 64)->default('');
			$table->string('address1')->default('');
			$table->string('address2')->default('');
			$table->string('address3')->default('');
			$table->string('postal', 16)->default('');
			$table->string('city')->default('');
			$table->string('state')->default('');
			$table->string('langid', 5)->nullable();
			$table->char('countryid', 2)->nullable();
			$table->string('telephone', 32)->default('');
			$table->string('telefax', 32)->default('');
			$table->string('website')->default('');
			$table->date('birthday')->nullable();
			$table->smallInteger('status')->default('1');
			$table->date('vdate')->nullable();
			$table->string('editor')->default('');

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
			$table->dropIndex('users_status_address1_index');
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
