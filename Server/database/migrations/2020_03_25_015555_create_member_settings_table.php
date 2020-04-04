<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMemberSettingsTable.
 */
class CreateMemberSettingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('member_settings', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('member_id')->unsigned();
            $table->tinyInteger('display_location')->default(0)->nullable();
            $table->tinyInteger('display_contact')->default(1)->nullable();
            $table->tinyInteger('offline_email')->default(1)->nullable();

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
		Schema::drop('member_settings');
	}
}
