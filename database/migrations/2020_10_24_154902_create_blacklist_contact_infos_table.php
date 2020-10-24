<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlacklistContactInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blacklist_contact_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("blacklist_user_id");
            $table->string("name")->nullable();
            $table->string("value")->nullable();
            $table->timestamps();
            $table->foreign('blacklist_user_id')->references('id')->on('blacklist_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blacklist_contact_infos');
    }
}
