<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('en_GB'); 
       
        for($i=0; $i<=100; $i++){
            \App\Models\Employee::factory()->create([
                'name' => $faker->name,
                'contact_no' => $faker->randomNumber,
                'designation' => $faker->shuffle,
                'profile' => $faker->shuffle,
                'department' => $faker->shuffle,
                'job_type' => $faker->shuffle,
                'email' => $faker->unique()->safeEmail,
                'joining_date' => $faker->shuffle,
                'status' => $faker->shuffle,
                'password' => $faker->password,
                'attendance' => $faker->shuffle,
            
 
            ]);
        }
    }
}
