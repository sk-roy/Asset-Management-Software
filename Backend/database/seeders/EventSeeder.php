<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Event;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::find(1);
        $asset = Asset::find(1);
        $category = Category::where('name', 'Service')->first();

        $event = Event::create([
            'title' => 'AC Service',
            'datetime' => '2024-09-25 10:00:00',
            'description' => 'AC serviceing',
            'charge' => 1200,
            'active_mode' => true,
            'map_location' => '1234 Business Street, Suite 500, Metropolis, NY',
        ]);

        $event->user()->associate($user);
        $event->asset()->associate($asset);
        $event->category()->associate($category);

        $event->save();
    }
}
