<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $religions = ['islam', 'kristen', 'katolik', 'hindu', 'budha', 'konghucu'];
        $countryCode = '+62';

        DB::table('users')->insert(
            [
                [
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'phone' => $countryCode . fake()->unique()->numerify('###########'),
                    'photo' => fake()->imageUrl(640, 480, 'people'),
                    'gender' => rand(0, 1),
                    'religion' => $religions[rand(0, 5)],
                    'date_of_birth' => '1990-01-01',
                    'place_of_birth' => 'Jawa Tengah',
                    'address' => fake()->address,
                    'email_verified_at' => now(),
                    'password' => bcrypt('admin123'),
                    'remember_token' => Str::random(10),
                    'role_id' => Role::find(1)->id,
                    'created_at' => now(),
                ],
                [
                    'name' => 'Dosen 1',
                    'email' => 'dosen1@gmail.com',
                    'phone' => $countryCode . fake()->unique()->numerify('###########'),
                    'photo' => fake()->imageUrl(640, 480, 'people'),
                    'gender' => rand(0, 1),
                    'religion' => $religions[rand(0, 5)],
                    'date_of_birth' => '1980-07-07',
                    'place_of_birth' => 'Jakarta Timur',
                    'address' => fake()->address,
                    'email_verified_at' => now(),
                    'password' => bcrypt('12345678'),
                    'remember_token' => Str::random(10),
                    'role_id' => Role::find(2)->id,
                    'created_at' => now(),
                ],
                [
                    'name' => 'Dosen 2',
                    'email' => 'dosen2@gmail.com',
                    'phone' => $countryCode . fake()->unique()->numerify('###########'),
                    'photo' => fake()->imageUrl(640, 480, 'people'),
                    'gender' => rand(0, 1),
                    'religion' => $religions[rand(0, 5)],
                    'date_of_birth' => '1980-09-15',
                    'place_of_birth' => 'Jakarta Selatan',
                    'address' => fake()->address,
                    'email_verified_at' => now(),
                    'password' => bcrypt('12345678'),
                    'remember_token' => Str::random(10),
                    'role_id' => Role::find(2)->id,
                    'created_at' => now(),
                ],
                [
                    'name' => 'Taya',
                    'email' => 'student1@gmail.com',
                    'phone' => $countryCode . fake()->unique()->numerify('###########'),
                    'photo' => fake()->imageUrl(640, 480, 'people'),
                    'gender' => rand(0, 1),
                    'religion' => $religions[rand(0, 5)],
                    'date_of_birth' => '2000-04-16',
                    'place_of_birth' => 'Bekasi',
                    'address' => fake()->address,
                    'email_verified_at' => now(),
                    'password' => bcrypt('12345678'),
                    'remember_token' => Str::random(10),
                    'role_id' => Role::find(3)->id,
                    'created_at' => now(),
                ]
            ]
        );

        User::find(2)->lecturer()->create(['nrp' => '123456789']);
        User::find(3)->lecturer()->create(['nrp' => '987654321']);
        User::find(4)->student()->create(['nim' => '2110511003']);
    }
}
