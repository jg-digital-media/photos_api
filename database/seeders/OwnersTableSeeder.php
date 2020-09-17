<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OwnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //connect factory to seeder
        //factory( \App\Models\Owner::class, 10)->create();
        \App\Models\Owner::factory()->count(10)->create(); 

    }
}
