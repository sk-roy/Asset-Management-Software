<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Land/Flat', 'title' => 'Land or Flat', 'type' => 'Asset']);
        Category::create(['name' => 'Electronic Device', 'title' => 'Electronic Device', 'type' => 'Asset']);
        Category::create(['name' => 'Furniture', 'title' => 'Furniture','type' => 'Asset']);
        Category::create(['name' => 'Vehicle', 'title' => 'Vehicle', 'type' => 'Asset']);
        Category::create(['name' => 'Jewelry', 'title' => 'Jewelry', 'type' => 'Asset']);
        
        Category::create(['name' => 'Service', 'title' => 'Service', 'type' => 'Event']);
        Category::create(['name' => 'Clean', 'title' => 'Clean', 'type' => 'Event']);
        Category::create(['name' => 'Replace', 'title' => 'Replace', 'type' => 'Event']);
        Category::create(['name' => 'Visit', 'title' => 'Visit', 'type' => 'Event']);
        Category::create(['name' => 'Bill Payment', 'title' => 'Bill Payment', 'type' => 'Event']);
    }
}
