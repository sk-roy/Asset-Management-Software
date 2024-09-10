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
        Category::create(['name' => 'Land/Flat', 'title' => 'Land or Flat']);
        Category::create(['name' => 'Electronic Device', 'title' => 'Electronic Device']);
        Category::create(['name' => 'Furniture', 'title' => 'Furniture']);
        Category::create(['name' => 'Vehicle', 'title' => 'Vehicle']);
        Category::create(['name' => 'Jewelry', 'title' => 'Jewelry']);
    }
}
