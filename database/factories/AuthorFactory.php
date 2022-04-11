<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    // @return this
    /*
    laravel >=8 use configure function to use factory callback 
    */
    public function configure()
    {
        return $this->afterCreating(function(Author $author) {
            $author->profile()->save(Profile::factory()->create([
                'author_id' => $author->id
            ]));
        });
    }
}
