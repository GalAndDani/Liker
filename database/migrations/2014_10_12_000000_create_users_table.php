<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('gender');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('picture')->nullable();
            $table->date('birthday')->nullable();
            $table->string('country');
            $table->integer('points')->default(100);
            $table->string('ref_id')->unique();
            $table->string('ref_user_id')->nullable();
            $table->string('email_token')->nullable();
            $table->tinyInteger('verified')->default(0);
            $table->rememberToken();
            $table->string('fb_user_id')->nullable();
            $table->string('fb_user_token')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
