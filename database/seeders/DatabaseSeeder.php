<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ActivitySeeder::class);
        $this->call([
        AssignmentActivitySeeder::class,
    ]);

    $this->call([
    EmailActivitySeeder::class,
]);

  $this->call([
    GdbActivitySeeder::class,
]);

  $this->call([
    MdbActivitySeeder::class,
]);

  $this->call([
    SessionActivitySeeder::class,
]);

  $this->call([
    TicketActivitySeeder::class,
]);
    }
}
