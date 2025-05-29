<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserGroup;
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
        $adminGroup = UserGroup::create(['name' => 'admin']);
        $studentGroup = UserGroup::create(['name' => 'student']);

        User::create([
            'name' => 'Iron Man',
            'email' => 'ironman@idk.com',
            'password' => Hash::make('1234'),
            'usergroup_id' => $adminGroup->id,
        ]);

        User::create([
            'name' => 'Heaven&Hell',
            'email' => 'heaven&hell@idk.com',
            'password' => Hash::make('1234'),
            'usergroup_id' => $studentGroup->id,
        ]);
    }
}
