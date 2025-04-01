<?php

namespace Database\Seeders;

use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VotesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vote::create([
            'vote' => true,
            'user_id' => 2,
            'album_id' => 1,
        ]);

        Vote::create([
            'vote' => true,
            'user_id' => 2,
            'album_id' => 2,
        ]);
    }
}
