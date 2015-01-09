<?php

use Illuminate\Database\Migrations\Migration;

class ConfideSetupUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Creates the users table
        Schema::table('users', function ($table) {
            //$table->increments('id');
            $table->string('username')->unique();
            //$table->string('email')->unique();
            $table->string('password');
            $table->string('confirmation_code');
            $table->string('remember_token')->nullable();
            $table->boolean('confirmed')->default(false);
            //$table->timestamps();
        });

        // Creates password reminders table
        Schema::create('password_reminders', function ($table) {
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('password_reminders');
        Schema::table('users', function ($table) {
            $table->dropColumn('username');
            $table->dropColumn('password');
            $table->dropColumn('confirmation_code');
            $table->dropColumn('remember_token');
            $table->dropColumn('confirmed');
        });
    }
}
