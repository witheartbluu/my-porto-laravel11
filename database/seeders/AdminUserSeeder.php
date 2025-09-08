<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeders.
     */
    public function run(): void
    {
        // $users = [
        //     [
        //         'name' => 'admin',
        //         'email' => 'admin@email.com',
        //         'password' => Hash::make('123')
        //     ]
        //     ];
        User::create([
            'name' => 'Admin',
            'email' => 'admin@email.com',
            'password' => Hash::make('123'), // hashed password
        ]);
    }
}