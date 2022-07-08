<?php

use App\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'type' => 'admin',
            'name' => 'admin',
            'email' => 'adapah@gmail.com',
             'password' => Hash::make('qwe123')
            ]);
    }
}
