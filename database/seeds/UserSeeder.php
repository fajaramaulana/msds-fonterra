<?php

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
        User::insert([[
            'name' => 'Alif Ridho Utama',
            'email' => 'alif@mail.com',
            'password' => Hash::make(12345678),
            'departement_id' => 4,
        ]]);
    }
}
