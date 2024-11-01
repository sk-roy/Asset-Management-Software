<?php

namespace Database\Seeders;

use App\Models\Asset;
use App\Models\Note;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $note = Note::create([
            'title' => 'Nice phone',
            'description' => 'got 20% discount',
        ]);

        $asset = Asset::find(1);
        $user = User::find(1);
        $note->asset()->associate($asset);
        $note->user()->associate($user);
        $note->save();
    }
}
