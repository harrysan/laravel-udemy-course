<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //$comments = 
        $posts = BlogPost::all();
        $users = User::all();

        if($posts->count() === 0 || $users->count() === 0)
        {
            $this->command->info('There are no blog posts, so no comments will be added');
            return;
        }

        $commentsCount = (int)$this->command->ask('How many comments would you like?', 150);
        
        // factory for blogpost comment
        Comment::factory()->count($commentsCount)->make()->each(
            function($comments) use ($posts, $users) {
                $comments->commentable_id = $posts->random()->id;
                $comments->commentable_type = 'App\Models\BlogPost';
                $comments->user_id = $users->random()->id;
                $comments->save();
            }
        );

        // factory for user comment
        Comment::factory()->count($commentsCount)->make()->each(
            function($comments) use ($users) {
                $comments->commentable_id = $users->random()->id;
                $comments->commentable_type = 'App\Models\User';
                $comments->user_id = $users->random()->id;
                $comments->save();
            }
        );
    }
}
