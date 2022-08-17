<?php

namespace Database\Seeders;

use App\Domain\Column\ColumnPreFiller;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
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
        $user = User::create([
            'email' => 'christoph.karlen@ffhs.ch',
            'name' => 'Christoph Karlen',
            'password' => Hash::make('christoph.karlen@ffhs.ch'),
        ]);

        $user = User::create([
            'email' => 'dummy.user@ffhs.ch',
            'name' => 'Dummy User',
            'password' => Hash::make('dummy.user@ffhs.ch'),
        ]);

    }

    private static function strRandom($length = 16) {
        return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    }
}
