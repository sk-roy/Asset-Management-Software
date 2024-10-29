<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        Category::create(['name' => 'Land/Flat', 'title' => 'Land or Flat', 'description' => $faker->sentence, 'type' => 'Asset']);
        Category::create(['name' => 'Electronic Device', 'title' => 'Electronic Device', 'description' => $faker->sentence, 'type' => 'Asset']);
        Category::create(['name' => 'Furniture', 'title' => 'Furniture', 'description' => $faker->sentence,'type' => 'Asset']);
        Category::create(['name' => 'Vehicle', 'title' => 'Vehicle', 'description' => $faker->sentence, 'type' => 'Asset']);
        Category::create(['name' => 'Jewelry', 'title' => 'Jewelry', 'description' => $faker->sentence, 'type' => 'Asset']);
        
        Category::create(['name' => 'Service', 'title' => 'Service', 'description' => $faker->sentence, 'type' => 'Event']);
        Category::create(['name' => 'Clean', 'title' => 'Clean', 'description' => $faker->sentence, 'type' => 'Event']);
        Category::create(['name' => 'Replace', 'title' => 'Replace', 'description' => $faker->sentence, 'type' => 'Event']);
        Category::create(['name' => 'Visit', 'title' => 'Visit', 'description' => $faker->sentence, 'type' => 'Event']);
        Category::create(['name' => 'Bill Payment', 'title' => 'Bill Payment', 'description' => $faker->sentence, 'type' => 'Event']);
    }
}
