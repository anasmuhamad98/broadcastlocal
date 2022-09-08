<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('personal_access_tokens')->insert([
            'tokenable_type' => 'App\Models\User',
            'tokenable_id' => '1',
            'name' => 'API TOKEN',
            'token' => 'ba0ae1a94609bc247af36287e621ac021eb29d9be5d2808906ecad7535a3bea9',
            'abilities' => '["*"]',
        ]);
    }
}
