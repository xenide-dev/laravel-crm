<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $userID = DB::table('users')->insertGetId([
            'fname' => $faker->firstNameMale,
            'mname' => $faker->lastName,
            'lname' => $faker->lastName,
            'id_number' => $faker->randomNumber(6),
            'phone_number' => $faker->randomNumber(5),
            'email' => "admin@admin.com",
            'password' => Hash::make('admin'),
            'isPassChanged' => 1,
            'user_type' => "super-admin",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'api_token' => Hash::make(now()),
        ]);

        // populate the user's permission
        // by default all
        // get the config in _privileges.php
        $configs = config("_privileges.urls");
        foreach ($configs as $config){
            foreach ($config["access"] as $access){
                DB::table('user_permissions')->insert([
                    'user_id' => $userID,
                    "name" => $config["name"],
                    "slug" => Str::slug($access . " " . $config["name"]),
                    'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                    'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                ]);
            }
        }

        for($i = 0; $i < 20; $i++){
            $faker = Faker\Factory::create();
            $firstName = $faker->firstNameMale;
            DB::table('users')->insert([
                'fname' => $firstName,
                'mname' => $faker->lastName,
                'lname' => $faker->lastName,
                'id_number' => $faker->randomNumber(6),
                'phone_number' => $faker->randomNumber(5),
                'email' => $faker->freeEmail,
                'password' => Hash::make($firstName),
                'user_type' => "user",
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'api_token' => Hash::make(now()),
            ]);
        }
    }
}
