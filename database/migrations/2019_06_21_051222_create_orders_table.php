<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name'); 
			$table->integer('age');
			$table->integer('quantity');
			$table->string('hospital_name');
			$table->string('hospital_address');
			$table->decimal('latitude', 10,8)->nullable();
			$table->decimal('longtude', 10,8)->nullable();
			$table->integer('city_id');
			$table->string('mobile');
			$table->text('note')->nullable();
			$table->integer('client_id');
			$table->enum('blood_type',array('A+', 'A-','B+','B-','AB+','AB-','O+','O-'));
		});
	}

	public function down()
	{
		Schema::drop('orders');
	}
}