<?php

namespace Tests\Feature;

use App\Models\Site;
use Tests\TestCase;

class SubscriberPostList extends TestCase
{
    public function test_post_list_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())->getJson('/api/subscriber-posts/list');
        $response->assertStatus(200);
    }

    public function test_post_latest_list_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())->getJson('/api/subscriber-posts/latest/list');
        $response->assertStatus(200);
    }

    public function test_post_with_specify_site_list_returns_a_successful_response()
    {
        $site = Site::query()->firstOrFail();

        $response = $this->actingAs($this->getActingUser())->getJson('/api/subscriber-posts/' . $site->id . '/list');
        $response->assertStatus(200);
    }

    public function test_post_list_filters_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())
            ->getJson('/api/subscriber-posts?is_published=1&site_id=1');

        $response->assertStatus(200);
    }
}
