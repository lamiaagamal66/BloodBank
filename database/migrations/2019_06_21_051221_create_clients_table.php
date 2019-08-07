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
			$table->enum('blood_type',array('A+', 'A-','B+','B-','AB+','AB-','O+','O-'));
			$table->integer('city_id');
			$table->integer('pin_code')->unique()->nullable();
			$table->string('api_token', 60)->unique()->nullable();
			$table->boolean('is_active')->default(1);

		});
	}

	public function down()
	{
		Schema::drop('clients');
	}
}