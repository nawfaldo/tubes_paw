<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        DB::table('admin')->insert([
            'nip' => '123456',
            'nama' => 'Admin',
            'email' => 'ditmawa2025@gmail.com',
            'password' => Hash::make('ditmawa25'),
            'jabatan' => 'Admin',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
