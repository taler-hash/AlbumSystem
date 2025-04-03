<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Album::create([
            'name' => 'Hurry Up Tomorrow',
            'artist_name' => 'The Weeknd',
        ]);

        Album::create([
            'name' => 'NSFW',
            'artist_name' => 'Tyga',
        ]);

        Album::create([
            'name' => 'Alter Ego',
            'artist_name' => 'Lisa',
        ]);

        Album::create([
            'name' => 'Mayhem',
            'artist_name' => 'Lady Gaga',
        ]);

        for($x = 0; $x < 30; $x++) {
            Album::create([
                'name' => fake()->name,
                'artist_name' => fake()->name,
            ]);
        }
    }
}
