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
            $table->dateTime("banned_date")->nullable();
            $table->string("fname")->nullable();
            $table->string("mname")->nullable();
            $table->string("lname")->nullable();
            $table->string("full_name")->nullable();
            $table->string("id_number")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("email")->nullable();
            $table->longText("notes")->nullable();
            $table->longText("notified_user_ids")->nullable()->comment("the user's id who see this blacklist user ex. 1|2|3");
            $table->unsignedBigInteger("added_by_id")->nullable()->comment("the one who added");
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
