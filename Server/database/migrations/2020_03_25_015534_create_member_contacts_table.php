<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMemberContactsTable.
 */
class CreateMemberContactsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('member_contacts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->string('email', 200)->unique();
            $table->string('mobile_phone', 12)->nullable();
            $table->string('home_phone', 12)->nullable();
            $table->string('office_phone', 12)->nullable();
            $table->text('address1')->nullable();
            $table->text('address2')->nullable();

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
		Schema::drop('member_contacts');
	}
}
