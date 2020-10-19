<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlacklistUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blacklist_users', function (Blueprint $table) {
            $table->id();
            $table->string("fname")->nullable();
            $table->string("mname")->nullable();
            $table->string("lname")->nullable();
            $table->string("id_number")->nullable();
            $table->string("position")->nullable();
            $table->unsignedBigInteger("added_by_id")->comment("the one who added");
            $table->timestamps();
            $table->foreign('added_by_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blacklist_users');
    }
}
