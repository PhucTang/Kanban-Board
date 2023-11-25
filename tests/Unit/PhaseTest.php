<?php

namespace Tests\Unit;

use App\Models\Phase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PhaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_success(): void
    {
        $phase = Phase::factory()->create();

        $this->assertDatabaseHas('phases', ['id' => $phase->id]);
    }

    public function test_can_update_success(): void
    {
        $phase = Phase::factory()->create();

        $this->assertDatabaseHas('phases', ['id' => $phase->id]);

        $phase->order_number = 2;

        $phase->save();

        $this->assertDatabaseHas('phases', ['id' => $phase->id, 'order_number' => 2]);
    }

    public function test_can_delete_success(): void
    {
        $phase = Phase::factory()->create();

        $this->assertDatabaseHas('phases', ['id' => $phase->id]);

        $phase->delete();

        $this->assertDatabaseMissing('phases', ['id' => $phase->id]);
    }
}
