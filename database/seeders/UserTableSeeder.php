<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@app.com',
            'role' => 1,
            'designation' => 'Managing Director',
            'phone_no' => '01614898789',
            'profile_photo' => null,
            'email_verified_at' => now(),
            'status' => 1,
            'password' => Hash::make('password'),
        ]);
    }
}
