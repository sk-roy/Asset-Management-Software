<?php

namespace Database\Seeders;

use App\Models\Asset;
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
        $user = User::Find(1);
        $categoryId = 2;

        // Insert 2 mobile phones
        for ($i = 0; $i < 2; $i++) {
            $user->assets()->create([
                'title' => $faker->word . ' Mobile',
                'purchase_price' => $faker->randomFloat(2, 100, 1000),
                'purchase_date' => $faker->date,
                'brand' => $faker->word,
                'model' => $faker->word,
                'capacity' => $faker->randomFloat(2, 1, 256),
                'specification' => '8/256',
            ]);
        }


        // Insert 3 car
        for ($i = 0; $i < 3; $i++) {
            $user->assets()->create([
                'title' => $faker->word . ' Car',
                'purchase_price' => $faker->randomFloat(2, 5000, 30000),
                'purchase_date' => $faker->date,
                'brand' => $faker->word,
                'model' => $faker->word,
                'plate_number' => $faker->bothify('??-###'),
                'capacity' => 1200, // unit is CC
            ]);
        }

    }
}
