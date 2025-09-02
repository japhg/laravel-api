<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name'     => 'James Philip Gomera',
                'username' => 'jpgomera19',
                'email'    => 'jpgomera19@gmail.com',
                'password' => Hash::make('password'),
            ],
            [
                'name'     => 'Admin',
                'username' => 'admin',
                'email'    => 'admin@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(['email' => $user['email']], $user);
        }
    }
}
