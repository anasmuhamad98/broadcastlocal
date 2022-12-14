<?php

namespace Database\Seeders;

use App\Models\RakeCode;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            // ChatRoomSeeder::class,
            UserSeeder::class,
            GrouperSeeder::class,
            TackSeeder::class,
            ListASeeder::class,
            ListBSeeder::class,
            ListCSeeder::class,
            TableGrouperSeeder::class,
            RakeCodeSeeder::class,
            // TokenSeeder::class,
        ]);
    }
}
