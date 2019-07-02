<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientsTable extends Migration {

	public function up()
	{
		Schema::create('clients', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name');
			$table->string('email');
			$table->date('date_of_birth');
			$table->date('last_donate');
			$table->string('mobile');
			$table->string('password');
			$table->string('api_token', 60);
			$table->integer('blood_type_id');
			$table->integer('city_id');
			$table->integer('pin_code');
		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}