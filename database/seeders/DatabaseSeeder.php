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
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            PermissionRoleSeeder::class,
            DanceTypeSeeder::class,
            DancePartSeeder::class,
            DancePartVideoSeeder::class,
            DanceSeeder::class,
            DanceCostumeSeeder::class,
        ]);
    }
}
