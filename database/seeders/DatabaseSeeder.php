<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\Role::factory()->create([
           'name' => 'Client'
        ]);

        \App\Models\Role::factory()->create([
            'name' => 'Moderator'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'password' => bcrypt('12345678'),
            'role_id' => 2
        ]);

        \App\Models\User::factory(10)->create();
    }
}
