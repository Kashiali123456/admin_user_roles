<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class UserTablesseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB');  
        for($i=0; $i<=100; $i++){
        \App\Models\User::factory()->create([
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'contact_no' => $faker->randomNumber,
        'designation' => $faker->shuffle,
        'department' => $faker->shuffle,
        'job_type' => $faker->shuffle,
        'joining_date' => $faker->shuffle,
        'password' => $faker->password,
        
    ]);
}
    }
}
