<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

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
        // DB::table('users')->insert([
        //     'name' => 'John Doe',
        //     'email' => 'john@laravel.text',
        //     'email_verified_at' => now(),
        //     'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //     'remember_token' => Str::random(10),
        // ]);

        if($this->command->confirm('Do you want to refresh the database?'))
        {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }

        Cache::tags('blog-post')->flush();

        //in order
        $this->call([UsersTableSeeder::class, 
                    BlogPostsTableSeeder::class, 
                    CommentsTableSeeder::class]);
    }
}
