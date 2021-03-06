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
            $table->string('name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('birth_date')->nullable();
            $table->string('rut')->nullable();
            $table->string('validate')->nullable();
            $table->integer('role_id')->unsigned();
            $table->integer('status');
            $table->rememberToken();
            $table->timestamps();           
        });

        Schema::table('users', function($table) {
            $table->foreign('role_id')->references('id')->on('roles');
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
