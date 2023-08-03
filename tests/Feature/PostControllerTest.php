<?php

namespace Tests\Feature;

use App\Events\PostPublished;
use App\Models\Post;
use App\Models\Site;
use Illuminate\Foundation\Testing\WithoutEvents;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
//    use WithoutEvents;

    public function test_post_list_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())->getJson('/api/publish-posts');
        $response->assertStatus(200);
    }

    public function test_post_latest_list_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())->getJson('/api/publish-posts/latest/list');
        $response->assertStatus(200);
    }

    public function test_post_with_specify_site_list_returns_a_successful_response()
    {
        $site = Site::query()->firstOrFail();

        $response = $this->actingAs($this->getActingUser())->getJson('/api/publish-posts/' . $site->id . '/list');
        $response->assertStatus(200);
    }

    public function test_post_list_filters_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())
            ->getJson('/api/publish-posts?is_published=1&site_id=1');

        $response->assertStatus(200);
    }

    public function test_create_post_returns_a_successful_response()
    {
        $title = fake()->title;
        $body = fake()->realText;

        $response = $this->actingAs($this->getActingUser())
            ->postJson('/api/publish-posts', [
                'title' => $title,
                'body' => $body,
                'site_id' => Site::query()->firstOrFail()->id,
                'is_published' => 0
            ]);

//        Event::assertDispatched(PostPublished::class);

        $response->assertStatus(201);
        $this->assertSame($response->json('title'), $title);
        $this->assertSame($response->json('body'), $body);
        $this->assertFalse($response->json('is_published'));
    }

    public function test_update_post_returns_a_successful_response()
    {
        $lastItem = Post::query()->latest()->firstOrFail();

        $newTitle = fake()->title;
        $newBody = fake()->realText;

        $response = $this->actingAs($this->getActingUser())
            ->putJson('/api/publish-posts/' . $lastItem->id, [
                'title' => $newTitle,
                'body' => $newBody,
                'is_published' => 1
            ]);

//        Event::assertNotDispatched(PostPublished::class);

        $lastEditedItem = Post::query()->findOrFail($lastItem->id);

        $response->assertStatus(202);

        $this->assertSame($newTitle, $lastEditedItem->title);
        $this->assertSame($newBody, $lastEditedItem->body);
        $this->assertTrue($lastEditedItem->is_published);
    }

    public function test_delete_post_returns_a_successful_response()
    {
        $lastItem = Post::query()->latest()->firstOrFail();

        $response = $this->actingAs($this->getActingUser())
            ->deleteJson('/api/publish-posts/' . $lastItem->id);

        $response->assertStatus(204);
    }
}
