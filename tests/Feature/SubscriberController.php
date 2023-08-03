<?php

namespace Tests\Feature;

use App\Models\Site;
use Tests\TestCase;

class SubscriberController extends TestCase
{
    public function test_user_subscribe_sites_list_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())
            ->getJson('/api/subscribe/list');

        $response->assertStatus(204);
    }

    public function test_user_subscribe_returns_a_successful_response()
    {
        $site = Site::query()->firstOrFail();

        $response = $this->actingAs($this->getActingUser())
            ->postJson('/api/subscribe', [
                'address' => $site->address
            ]);

        $response->assertStatus(204);
    }
}
