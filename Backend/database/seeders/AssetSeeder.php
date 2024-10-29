<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class AssetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $user = User::find(1);
        
        // Insert 2 mobile phones
        $category = Category::find(2);
        for ($i = 0; $i < 2; $i++) {
            $asset = Asset::create([
                'title' => $faker->word . ' Mobile ' . $i,
                'description' => $faker->paragraph,
                'purchase_price' => $faker->randomFloat(2, 100, 1000),
                'purchase_date' => $faker->date,
                'brand' => $faker->word,
                'model' => $faker->word,
                'capacity' => $faker->randomFloat(2, 1, 256),
                'specification' => '8/256',
            ]);

            $asset->user()->associate($user);
            $asset->category()->associate($category);

            $asset->save();
        }


        // Insert 3 car
        $category = Category::find(4);
        for ($i = 0; $i < 3; $i++) {
            $asset = Asset::create([
                'title' => $faker->word . ' Car ' . $i,
                'description' => $faker->paragraph,
                'purchase_price' => $faker->randomFloat(2, 5000, 30000),
                'purchase_date' => $faker->date,
                'brand' => $faker->word,
                'model' => $faker->word,
                'plate_number' => $faker->bothify('??-###'),
                'capacity' => 1200, // unit is CC
            ]);

            $asset->user()->associate($user);
            $asset->category()->associate($category);
            
            $asset->save();
        }
    }
}
