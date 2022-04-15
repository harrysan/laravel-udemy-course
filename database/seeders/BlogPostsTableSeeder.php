<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class BlogPostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //$posts = 
        $blogCount = (int)$this->command->ask('How many blog posts would you like?', 50);
        $users = User::all();

        BlogPost::factory()->count($blogCount)->make()->each(
            function($posts) use ($users) {
                $posts->user_id = $users->random()->id;
                $posts->save();
            }
        );
    }
}
