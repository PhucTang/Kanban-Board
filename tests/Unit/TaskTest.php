<?php

namespace Tests\Unit;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_success(): void
    {
        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);
    }

    public function test_can_update_success(): void
    {
        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $testNow = Carbon::parse('11/25/2023');
        Carbon::setTestNow($testNow);

        $task->completed_at = now();

        $task->save();

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'completed_at' => $testNow]);
    }

    public function test_can_delete_success(): void
    {
        $task = Task::factory()->create();

        $this->assertDatabaseHas('tasks', ['id' => $task->id]);

        $task->delete();

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
