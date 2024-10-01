<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['title' => 'Author']);
        Role::create(['title' => 'Editor']);
        Role::create(['title' => 'Reviewer']);

        User::create([
            'fullname' => 'Author',
            'email' => 'Author@example.com',
            'username' => 'Author',
            'password' => Hash::make('password'),
            'role_id' => Role::where('title', 'Author')->first()->id
        ]);

        User::create([
            'fullname' => 'Editor',
            'email' => 'Editor@example.com',
            'username' => 'Editor',
            'password' => Hash::make('password'),
            'role_id' => Role::where('title', 'Editor')->first()->id
        ]);

        User::create([
            'fullname' => 'Reviewer',
            'email' => 'Reviewer@example.com',
            'username' => 'Reviewer',
            'password' => Hash::make('password'),
            'role_id' => Role::where('title', 'Reviewer')->first()->id
        ]);
    }
}
