<?php

namespace Database\Seeders;

use App\Models\Poliklinik;
use App\Models\User;
use Illuminate\Database\Seeder;

class poliklinikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('username', 'poliklinik')->first();

        $user->polikliniks()->create([
            'code'  => 'POLI-UMUM',
            'name'  => 'Poliklinik Umum'
        ]);
    }
}
