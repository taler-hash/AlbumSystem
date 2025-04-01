<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'username' => 'admin',
            'password' => Hash::make('admin')
        ]);

        $admin->assignRole('admin');

        $voter = User::create([
            'name' => 'voter',
            'username' => 'voter',
            'password' => Hash::make('voter')
        ]);
    }
}
