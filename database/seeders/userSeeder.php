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
            'name'      => 'admin',
            'auth_level'=> 'admin',
        ]);

        User::create([
            'username'  => 'apotek',
            'password'  => Hash::make('apotek'),
            'name'      => 'apotek',
            'auth_level'=> 'apotek'
        ]);

        User::create([
            'username'  => 'poliklinik',
            'password'  => Hash::make('poliklinik'),
            'name'      => 'Poliklinik',
            'auth_level'=> 'poliklinik'
        ]);
    }
}
