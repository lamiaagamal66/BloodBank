<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateClientablesTable extends Migration {

	public function up()
	{
		Schema::create('clientables', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('client_id');
			$table->integer('clientable_id');
			$table->integer('clientable_type');
			$table->boolean('notification_is_read');
		});
	}

	public function down()
	{
		Schema::drop('clientables');
	}
}