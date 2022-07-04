<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'ahmad',
            'email' => 'ahmad@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        DB::table('users')->insert([
            'name' => 'anas',
            'email' => 'anas@gmail.com',
            'password' => bcrypt('12345678')
        ]);
        DB::table('users')->insert([
            'name' => 'ezzat',
            'email' => 'ezzat@gmail.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
