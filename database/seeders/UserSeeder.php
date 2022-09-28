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
        $user = User::create([
            'email' => 'christoph.karlen@ffhs.ch',
            'name' => 'christoph',
            'password' => Hash::make('christoph.karlen@ffhs.ch'),
        ]);

        $user = User::create([
            'email' => 'pedro.correia@lernende.bfo-vs.ch',
            'name' => 'pedro',
            'password' => Hash::make('pedro.correia@lernende.bfo-vs.ch'),
        ]);

        $user = User::create([
            'email' => 'luc.kromer@lernende.bfo-vs.ch',
            'name' => 'luc',
            'password' => Hash::make('luc.kromer@lernende.bfo-vs.ch'),
        ]);

        $user = User::create([
            'email' => 'luka.stanisic@lernende.bfo-vs.ch',
            'name' => 'luka',
            'password' => Hash::make('luka.stanisic@lernende.bfo-vs.ch'),
        ]);

        $user = User::create([
            'email' => 'giacomo.piperata@lernende.bfo-vs.ch',
            'name' => 'giacomo',
            'password' => Hash::make('giacomo.piperata@lernende.bfo-vs.ch'),
        ]);
    }

    private static function strRandom($length = 16)
    {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }
}
