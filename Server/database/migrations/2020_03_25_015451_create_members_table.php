<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateMembersTable.
 */
class CreateMembersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function(Blueprint $table) {
            $table->increments('id');
            $table->string('username', 100)->unique();
            $table->string('password');
            $table->string('name', 100);
            $table->string('avatar')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->date('birthday')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->default('other')->nullable();
            $table->enum('status', ['verify', 'active'])->default('verify')->nullable();

            $table->rememberToken();
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
		Schema::drop('members');
	}
}
