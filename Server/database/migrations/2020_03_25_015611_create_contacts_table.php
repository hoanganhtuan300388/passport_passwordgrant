<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateContactsTable.
 */
class CreateContactsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned()->nullable();
            $table->integer('friend_id')->unsigned()->nullable();
            $table->integer('group_id')->unsigned()->nullable();
            $table->timestamp('action_at')->default(\DB::raw('CURRENT_TIMESTAMP'))->nullable();

            $table->unique(['member_id', 'friend_id', 'group_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contacts');
	}
}
