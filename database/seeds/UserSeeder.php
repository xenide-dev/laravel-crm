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
            'user_type' => "admin",
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
