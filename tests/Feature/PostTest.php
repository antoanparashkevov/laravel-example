<?php

namespace Tests\Feature;



use App\Models\Blogpost;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Illuminate\Foundation\Testing\WithFaker;


use Tests\TestCase;

class PostTest extends TestCase
{


    use RefreshDatabase;

    public function testNoBlogPostsWhenNothingInDatabase()
    {
        $response = $this->get('/posts');

        $response->assertSeeText('No posts found');
    }

    public function testSee1BlogPostWhenThereIs1()
    {
        $post = $this->createDummyBlogPost();


        $response = $this->get('/posts');

        $response->assertSeeText('New title');



        $this->assertDatabaseHas('blogposts', [
            'title' => 'New title'
        ]);
    }

    public function testStoreValid()
    {
        $params = [
            'title' => 'Valid title',
            'content' => 'At least 10 characters'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)

            ->assertSessionHas('status');



        $this->assertEquals(session('status'), 'The blog post was created!');

    }
    public function testStoreFail()
    {
        $params = [
            'title' => 'x',
            'content' => 'x'
        ];

        $this->post('/posts', $params)
            ->assertStatus(302)
            ->assertSessionHas('errors');

        $messages = session('errors')->getMessages();



        $this->assertEquals($messages['title'][0], 'The title must be at least 5 characters.');
        $this->assertEquals($messages['content'][0], 'The content must be at least 10 characters.');

    }


    public function testUpdateValid()
    {

        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blogposts', $post->toArray());

        $params = [
            'title' => 'A new named title',
            'content' => 'A new named content'
        ];

        $this->put("/posts/{$post->id}", $params)
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was updated!');

        $this->assertDatabaseMissing('blogposts', $post->toArray());
        $this->assertDatabaseHas('blogposts',[
            'title' => 'A new named title',
        ]);
    }

    public function testDelete(){
        $post = $this->createDummyBlogPost();

        $this->assertDatabaseHas('blogposts', $post->toArray());

        $this->delete("/posts/{$post->id}")
            ->assertStatus(302)
            ->assertSessionHas('status');

        $this->assertEquals(session('status'), 'Blog post was deleted!');

        $this->assertDatabaseMissing('blogposts', $post->toArray());
}



private function createDummyBlogPost():Blogpost{
    $post = new Blogpost();
    $post->title = 'New title';
    $post->content = 'Content of the blog post';
    $post->save();
    return  $post;
}
}
