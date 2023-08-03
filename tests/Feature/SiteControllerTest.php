<?php

namespace Tests\Feature;

use App\Models\Site;
use Tests\TestCase;

class SiteControllerTest extends TestCase
{
    public function test_site_list_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())->getJson('/api/sites');
        $response->assertStatus(200);
    }

    public function test_site_list_filters_returns_a_successful_response()
    {
        $response = $this->actingAs($this->getActingUser())
            ->getJson('/api/sites?is_published=1&site_id=1');

        $response->assertStatus(200);
    }

    public function test_create_site_returns_a_successful_response()
    {
        $title = fake()->title;
        $address = fake()->url;

        $response = $this->actingAs($this->getActingUser())
            ->postJson('/api/sites', [
                'title' => $title,
                'address' => $address
            ]);

        $response->assertStatus(201);
        $this->assertSame($response->json('title'), $title);
        $this->assertSame($response->json('address'), $address);
    }

    public function test_update_site_returns_a_successful_response()
    {
        $lastItem = Site::query()->latest()->firstOrFail();

        $newTitle = fake()->title;
        $newAddress = fake()->url;

        $response = $this->actingAs($this->getActingUser())
            ->putJson('/api/sites/' . $lastItem->id, [
                'title' => $newTitle,
                'address' => $newAddress
            ]);

        $lastEditedItem = Site::query()->findOrFail($lastItem->id);

        $response->assertStatus(202);

        $this->assertSame($newTitle, $lastEditedItem->title);
        $this->assertSame($newAddress, $lastEditedItem->address);
    }

    public function test_delete_site_returns_a_successful_response()
    {
        $lastItem = Site::query()->latest()->firstOrFail();

        $response = $this->actingAs($this->getActingUser())
            ->deleteJson('/api/sites/' . $lastItem->id);

        $response->assertStatus(204);
    }
}
