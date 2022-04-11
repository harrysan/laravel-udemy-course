<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BlogPostFactory extends Factory
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
            'title' => $this->faker->sentence(),
            'content' => $this->faker->paragraphs(5, true),
        ];
    }

    public function new_title()
    {
        return $this->state([
            'title' => 'New Title',
            'content' => 'Content of the blog post',
        ]);
    }
}
