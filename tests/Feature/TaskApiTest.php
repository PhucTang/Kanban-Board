<?php

namespace Tests\Feature;

use App\Models\Phase;
use App\Models\Task;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TaskApiTest extends TestCase
{
    use RefreshDatabase;

    public function tearDown() : void
    {
        parent::tearDown();
    }

    public function test_can_create_success(): void
    {
        $this->assertGuest();

        $user = User::factory()->create();
        $phase = Phase::factory()->create();

        Sanctum::actingAs($user);

        $createData = [
            'name' => 'Test create tasks',
            'phase_id' => $phase->id,
            'user_id' => $user->id,
            'completed_at' => now(),
        ];

        $response = $this->post('/api/tasks', $createData);

        $this->assertDatabaseHas('tasks', $createData);

        $response->assertStatus(200);
    }

    public function test_cannot_create_without_login(): void
    {
        $this->assertGuest();

        $user = User::factory()->create();
        $phase = Phase::factory()->create();

        $createData = [
            'name' => 'Test create tasks',
            'phase_id' => $phase->id,
            'user_id' => $user->id,
            'completed_at' => now(),
        ];

        $response = $this->post('/api/tasks', $createData);

        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_can_update_success()
    {
        $this->assertGuest();

        $user = User::factory()->create();
        $phase = Phase::factory()->create();
        $task = Task::factory()->create();

        Sanctum::actingAs($user);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $updateData = [
            'name' => 'Test update tasks',
            'phase_id' => $phase->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(sprintf('/api/tasks/%s', $task->id), $updateData);

        $this->assertDatabaseHas('tasks', ['id' => $task->id] + $updateData);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $task->id,
            ...$updateData,
        ]);
    }

    public function test_cannot_update_without_login(): void
    {
        $this->assertGuest();

        $user = User::factory()->create();
        $phase = Phase::factory()->create();
        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $updateData = [
            'name' => 'Test update tasks',
            'phase_id' => $phase->id,
            'user_id' => $user->id,
        ];

        $response = $this->put(sprintf('/api/tasks/%s', $task->id), $updateData);

        $response->assertStatus(302)->assertRedirect('/login');
    }

    public function test_can_delete_success(): void
    {
        $this->assertGuest();

        $user = User::factory()->create();
        $task = Task::factory()->create();

        Sanctum::actingAs($user);

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $response = $this->delete(sprintf('/api/tasks/%s', $task->id));

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);

        $response->assertStatus(200);
    }

    public function test_cannot_delete_without_login(): void
    {
        $this->assertGuest();

        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $response = $this->delete(sprintf('/api/tasks/%s', $task->id));

        $response->assertStatus(302)->assertRedirect('/login');
    }
}
