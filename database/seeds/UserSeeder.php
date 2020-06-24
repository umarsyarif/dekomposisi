<?php

use App\User;
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
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678')
        ]);

        User::create([
            'name' => 'Hadisya',
            'email' => 'hadisyavi@gmail.com',
            'password' => '$2y$10$0Lcp813/SX6KSobX6zdEBeJfaeTUj19eCprA/x/H1ioHlHaPHSAqa'
        ]);
    }
}
