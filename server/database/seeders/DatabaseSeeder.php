<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        (new RoleSeeder())->run();
        (new UserSeeder())->run();
        (new AlbumSeeder())->run();
        (new VotesSeeder())->run();
    }
}
