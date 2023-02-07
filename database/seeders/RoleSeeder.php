<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
class RoleSeeder extends Seeder
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
            \App\Models\Role::factory()->create([
                'name' => $faker->name,
                'description' => $faker->paragraph
 
            ]);
        }
    }
}
