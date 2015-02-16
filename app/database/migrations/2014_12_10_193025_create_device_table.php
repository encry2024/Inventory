<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeviceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('devices', function($table) {
			$table->increments('id')->unsigned();
			$table->integer('category_id')->unsigned();
			$table->integer('location_id')->unsigned();
			$table->string('name');
			$table->string('status');
			$table->string('comment');
			$table->string('availability');
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
