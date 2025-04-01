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
    }
}
