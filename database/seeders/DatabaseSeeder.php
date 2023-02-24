<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Division;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $division = new Division();
        $division->name = "IT";
        $division->save();

        $division = new Division();
        $division->name = "Finance";
        $division->save();

        $user = new User();
        $user->name = 'admin';
        $user->username = 'admin';
        $user->role = 'admin';
        $user->password = bcrypt('admin');
        $user->save();

        $user = new User();
        $user->name = 'user1';
        $user->username = 'user1';
        $user->division_id = 2;
        $user->role = 'user';
        $user->password = bcrypt('user1');
        $user->save();

        $user = new User();
        $user->name = 'user2';
        $user->role = 'user';
        $user->username = 'user2';
        $user->division_id = 1;
        $user->password = bcrypt('user2');
        $user->save();
    }
}
