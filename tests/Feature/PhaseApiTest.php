<?php

namespace Tests\Feature;

use App\Models\Phase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PhaseApiTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_can_create_success(): void
    {
        $this->assertGuest();

        Sanctum::actingAs(User::factory()->create());

        $createData = [
            'name' => 'Test create phase',
            'order_number' => 2,
        ];

        $response = $this->post('/api/phases', $createData);

        $this->assertDatabaseHas('phases', $createData);

        $response->assertStatus(200);

        $response->assertJson([$createData]);
    }

    public function test_cannot_create_without_login(): void
    {
        $this->assertGuest();

        $response = $this->post('/api/phases', [
            'name' => 'Test create phase',
            'order_number' => 2,
        ]);

        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_can_update_success()
    {
        $this->assertGuest();

        Sanctum::actingAs(User::factory()->create());

        $phase = Phase::factory()->create();

        $this->assertDatabaseHas('phases', ['id' => $phase->id]);

        $updateData = [
            'name' => 'Test update phase',
        ];

        $response = $this->put(sprintf('/api/phases/%s', $phase->id), $updateData);

        $this->assertDatabaseHas('phases', ['id' => $phase->id] + $updateData);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $phase->id,
            ...$updateData,
        ]);
    }

    public function test_cannot_update_without_login(): void
    {
        $this->assertGuest();

        $phase = Phase::factory()->create();

        $this->assertDatabaseHas('phases', ['id' => $phase->id]);

        $updateData = [
            'name' => 'Test update phase',
        ];

        $response = $this->put(sprintf('/api/phases/%s', $phase->id), $updateData);

        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_can_delete_success(): void
    {
        $this->assertGuest();

        Sanctum::actingAs(User::factory()->create());

        $phase = Phase::factory()->create();

        $this->assertDatabaseHas('phases', ['id' => $phase->id]);

        $response = $this->delete(sprintf('/api/phases/%s', $phase->id));

        $this->assertDatabaseMissing('phases', ['id' => $phase->id]);

        $response->assertStatus(200);
    }

    public function test_cannot_delete_without_login(): void
    {
        $this->assertGuest();

        $phase = Phase::factory()->create();

        $this->assertDatabaseHas('phases', ['id' => $phase->id]);

        $response = $this->delete(sprintf('/api/phases/%s', $phase->id));

        $response->assertStatus(302)->assertRedirect('/login');
    }
}
