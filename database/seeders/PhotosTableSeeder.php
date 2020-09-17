<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //connect factory to seeder
        //factory( \App\Models\Photo::class, 10)->create();
        \App\Models\Photo::factory()->count(10)->create(); 

    }
}
