<?php

namespace Database\Seeders;

use Database\Seeders\AssetSeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\EventSeeder;
use Database\Seeders\FieldSeeder;
use Database\Seeders\NoteSeeder;
use Database\Seeders\UserSeeder;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {             
        $this->call([
            UserSeeder::class,
            CategorySeeder::class,
            AssetSeeder::class,
            EventSeeder::class,
            FieldSeeder::class,
            NoteSeeder::class,
        ]);
    }
}
