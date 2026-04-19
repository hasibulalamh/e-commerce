<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::where('email', 'hasib@gmail.com')->first();

        if (!$user) {
            User::create([
                'name' => 'hasib',
                'email' => 'hasib@gmail.com',
                'password' => bcrypt('123456'),
                'role' => 'admin',
            ]);
        } else {
            // Ensure existing user has admin role
            $user->update(['role' => 'admin']);
        }
    }
}
