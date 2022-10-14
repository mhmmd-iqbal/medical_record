<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class userSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username'  => 'admin',
            'password'  => Hash::make('admin'),
            'auth_level'=> 'admin'
        ]);

        User::create([
            'username'  => 'apotek',
            'password'  => Hash::make('apotek'),
            'auth_level'=> 'apotek'
        ]);

        User::create([
            'username'  => 'poliklinik',
            'password'  => Hash::make('poliklinik'),
            'auth_level'=> 'poliklinik'
        ]);
    }
}
