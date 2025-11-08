<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('admin');

        $instructor = User::create([ 
            'name' => 'instructor',
            'email' => 'instructor@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $instructor->assignRole('instructor');

        $user = User::create([
            'name' => 'john',
            'email' => 'john@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole('user');

        $viewer = User::create([
            'name' => 'viewer',
            'email' => 'viewer@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $viewer->assignRole('viewer');
    }
}
