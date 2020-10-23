<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->string('full_name');
            $table->string('suffix')->nullable();
            $table->string('id_number')->unique();
            $table->string('ign')->nullable();
            $table->string('phone_number');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('temp_password')->nullable();
            $table->string('user_type')->default("user")->comment("admin, user");
            $table->boolean('isPassChanged')->default("0")->comment("0 - not changed; 1 - has been changed");
            $table->boolean('isNotified')->default("0");
            $table->rememberToken();
            $table->timestamps();
            $table->timestamp("last_online_at")->nullable();
            $table->string('api_token', 80)->unique()->nullable()->default(null);
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
