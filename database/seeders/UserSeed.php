<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [

            [
                'name' => 'Emil',
                'email' => 'emill.memmedovv@gmail.com',
                'password' => Hash::make('password'),
                'type' => User::AUTHOR_TYPE
            ],
            [
                'name' => 'Jane',
                'email' => 'jane.jane@gmail.com',
                'password' => Hash::make('password2'),
                'type' => User::AUTHOR_TYPE
            ],
            [
                'name' => 'Mary',
                'email' => 'mary.mary@gmail.com',
                'password' => Hash::make('password3'),
                'type' => User::PUBLISHER_TYPE
            ],
        ];
        DB::table('users')->insert($users);
    }
}
