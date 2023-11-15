<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() : void {
        for ($i = 1; $i <= 10; $i++) {
            $users[] = [
                'email' => 'player' . $i . '@bfo.ch',
                'name' => 'player' . $i,
                'password' => Hash::make('player' . $i . '@bfo.ch'),
            ];
        }
        User::insert($users);
    }

    private static function strRandom($length = 16) {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
            ceil($length / strlen($x)))), 1, $length);
    }
}
