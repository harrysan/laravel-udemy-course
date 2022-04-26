<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testNoBlogPostWhenNothingInDatabase()
    {
        $response = $this->get('/posts');
        $response->assertSeeText('No blog posts yet!');
    }

    public function testSee1BlogPostWhenThereIs1WithNoComments()
    {
        // Arrange
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'Content of the blog post';
        // $post->save();
        $post = $this->createDummyBlogPost();

        // Act
        $response = $this->get('/posts');

        // Assert
        $response->assertSeeText('New Title');
        $response->assertSeeText('No comments yet!');

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]);
    }

    public function testSee1BlogPostWhenThereIs1WithComments()
    {
        //Arrange
        $user = $this->user();

        $post = $this->createDummyBlogPost();
        Comment::factory()->count(4)->create([
            'commentable_id' => $post->id,
            'commentable_type' => 'App\Models\BlogPost',
            'user_id' => $user
        ]);

        $response = $this->get('/posts');

        $response->assertSeeText('4 comments');
    }

    public function testStoreValid()
    {
        //$user = $this->user();

        $params = [
            'title' => 'New Title',
            'content' => 'New Content Lets Go'
        ];

        $this->actingAs($this->user())
            ->post('/posts',$params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blogpost was created');
    }

    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->actingAs($this->user())
            ->post('/posts',$params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();
        // dd($messages->getMessages());
        $this->assertEquals($messages['title'][0],'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0],'The content must be at least 10 characters.');
    }

    public function testUpdateValid()
    {
        // Arrange
        // $post = new BlogPost();
        // $post->title = 'New Title 2';
        // $post->content = 'Content of the blog post 2';
        // $post->save();
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', [
            'title' => 'New Title'
        ]);

        $params = [
            'title' => 'New Title 3',
            'content' => 'Content of the blog post 3'
        ];

        $this->actingAs($user)
        //($this->user())
            ->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'The blogpost was updated!');

        $this->assertDatabaseMissing('blog_posts', [
            'title' => 'New Title'
        ]);
    }

    public function testDelete()
    {
        $user = $this->user();
        $post = $this->createDummyBlogPost($user->id);

        $this->assertDatabaseHas('blog_posts', 
        [
            'title' => 'New Title'
        ]);

        $this->actingAs($user)
        //($this->user())
            ->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'BlogPost was deleted');
        // $this->assertDatabaseMissing('blog_posts', [
        //     'title' => 'New Title'
        // ]);
        $this->assertSoftDeleted('blog_posts', [
                'title' => 'New Title'
            ]);
    }

    private function createDummyBlogPost($userId = null)
    {
        // $post = new BlogPost();
        // $post->title = 'New Title';
        // $post->content = 'Content of the blog post';
        // $post->save();

        return BlogPost::factory()->new_title()->create((
            [
                'user_id' => $userId ?? $this->user()->id,
            ]
        ));

        // return $post;
    }
}
