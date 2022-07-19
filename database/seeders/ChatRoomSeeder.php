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
            'name' => 'LEKIR',
            'email' => 'LEKIR@gmail.com',
            'shortform' => 'H3',
            'password' => bcrypt('12345678')
        ]);
        DB::table('users')->insert([
            'name' => 'KELANTAN',
            'email' => 'KELANTAN@gmail.com',
            'shortform' => 'N5',
            'password' => bcrypt('12345678')
        ]);
        DB::table('users')->insert([
            'name' => 'SRIINDERASAKTI',
            'email' => 'SRIINDERASAKTI@gmail.com',
            'shortform' => 'F2',
            'password' => bcrypt('12345678')
        ]);
        DB::table('users')->insert([
            'name' => 'KASTURI',
            'email' => 'KASTURI@gmail.com',
            'shortform' => 'C1',
            'password' => bcrypt('12345678')
        ]);
        DB::table('users')->insert([
            'name' => 'MUTIARA',
            'email' => 'MUTIARA@gmail.com',
            'shortform' => 'R5',
            'password' => bcrypt('12345678')
        ]);
    }
}
