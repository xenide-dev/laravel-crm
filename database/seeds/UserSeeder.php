<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

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
        DB::table('users')->insert([
            'fname' => $faker->firstNameMale,
            'mname' => $faker->lastName,
            'lname' => $faker->lastName,
            'id_number' => $faker->randomNumber(6),
            'phone_number' => $faker->randomNumber(5),
            'email' => "admin@admin.com",
            'password' => Hash::make('admin'),
            'isPassChanged' => 1,
            'user_type' => "admin",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'api_token' => Hash::make(now()),
        ]);
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
