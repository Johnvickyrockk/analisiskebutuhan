<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'role' => 'superadmin',
            ],
            [
                'name' => 'Ache',
                'email' => 'ache@gmail.com',
                'role' => 'karyawan',
            ],
            [
                'name' => 'Melati',
                'email' => 'melati@gmail.com',
                'role' => 'karyawan2',
            ],
            [
                'name' => 'Bela',
                'email' => 'bela@gmail.com',
                'role' => 'karyawan3',
            ],
            [
                'name' => 'Rista',
                'email' => 'rista@gmail.com',
                'role' => 'karyawan4',
            ],
            [
                'name' => 'Amel',
                'email' => 'amel@gmail.com',
                'role' => 'karyawan5',
            ],
            [
                'name' => 'Putri',
                'email' => 'putri@gmail.com',
                'role' => 'karyawan6',
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['email' => $user['email']], // key untuk cari data
                [
                    'uuid' => Str::uuid(),
                    'name' => $user['name'],
                    'password' => Hash::make('password123'),
                    'role' => $user['role'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
    
