<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKnowYourClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('know_your_clients', function (Blueprint $table) {
            $table->id();
            $table->uuid("uuid_kyc")->nullable();
            $table->string("id_number")->nullable();
            $table->longText("passbase_authkey")->nullable();
            $table->string("ign")->nullable();
            $table->string("club_id")->nullable();
            $table->string("union_id")->nullable();
            $table->string("full_name")->nullable();
            $table->string("fname")->nullable();
            $table->string("mname")->nullable();
            $table->string("lname")->nullable();
            $table->string("suffix")->nullable();
            $table->string("email")->nullable();
            $table->string("phone_number")->nullable();
            $table->string("device_mac")->nullable();
            $table->string("device_ip")->nullable();
            $table->string("status")->default("Pending");
            $table->unsignedBigInteger("user_id")->nullable();
            $table->boolean("isDone")->default(0);
            $table->boolean("isLinkExpired")->default(0);
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('know_your_clients');
    }
}
