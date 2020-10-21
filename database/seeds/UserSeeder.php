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
        // =============================== For Admin 1 ===============================
        $faker = Faker\Factory::create();
        $firstName = $faker->firstNameMale;
        $middleName = $faker->lastName;
        $lastName = $faker->lastName;
        $userID = DB::table('users')->insertGetId([
            'fname' => $firstName,
            'mname' => $middleName,
            'lname' => $lastName,
            'full_name' => ucwords(sprintf("%s %s %s", $firstName, $middleName, $lastName)),
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

        // =============================== For Admin 2 ===============================
        $firstName = $faker->firstNameMale;
        $middleName = $faker->lastName;
        $lastName = $faker->lastName;
        $userID = DB::table('users')->insertGetId([
            'fname' => $firstName,
            'mname' => $middleName,
            'lname' => $lastName,
            'full_name' => ucwords(sprintf("%s %s %s", $firstName, $middleName, $lastName)),
            'id_number' => $faker->randomNumber(6),
            'phone_number' => $faker->randomNumber(5),
            'email' => "admin1@admin.com",
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

        // =============================== For other test super-admin ===============================
        // generate 9 random super admin
        for($i = 0; $i < 10; $i++){
            $tempEmail = $faker->freeEmail;
            $firstName = $faker->firstNameMale;
            $middleName = $faker->lastName;
            $lastName = $faker->lastName;
            $userID = DB::table('users')->insertGetId([
                'fname' => $firstName,
                'mname' => $middleName,
                'lname' => $lastName,
                'full_name' => ucwords(sprintf("%s %s %s", $firstName, $middleName, $lastName)),
                'id_number' => $faker->randomNumber(6),
                'phone_number' => $faker->randomNumber(5),
                'email' => $tempEmail,
                'password' => Hash::make($tempEmail),
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
        }


        // for 20 random acct with 'user' account type
//        for($i = 0; $i < 20; $i++){
//            $faker = Faker\Factory::create();
//            $firstName = $faker->firstNameMale;
//            DB::table('users')->insert([
//                'fname' => $firstName,
//                'mname' => $faker->lastName,
//                'lname' => $faker->lastName,
//                'id_number' => $faker->randomNumber(6),
//                'phone_number' => $faker->randomNumber(5),
//                'email' => $faker->freeEmail,
//                'password' => Hash::make($firstName),
//                'user_type' => "user",
//                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//                'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
//                'api_token' => Hash::make(now()),
//            ]);
//        }
    }
}
