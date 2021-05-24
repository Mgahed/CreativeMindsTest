<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username' => 'Abdelrhman Mgahed',
            'email' => 'abdelrhmanmgahed131@gmail.com',
            'role' => 'admin',
            'password' => hash::make('12345')
        ]);
    }
}
