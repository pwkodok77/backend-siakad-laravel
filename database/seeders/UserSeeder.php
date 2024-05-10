<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(50)->create();

        User::create([
            'name'=> 'Sandi Admin',
            'email'=> 'sandipw7777@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456'),
            'roles' => 'admin'
        ]);
    }

}

