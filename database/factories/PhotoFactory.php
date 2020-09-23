<?php

namespace Database\Factories;

use App\Models\Photo;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Photo::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            "url" => $this->faker->url,
            "caption" => $this->faker->text,
            "owner_id" => rand(1, \App\Models\Owner::count())
        ];
    }
}
