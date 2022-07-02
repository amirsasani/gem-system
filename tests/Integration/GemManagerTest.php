<?php

namespace Tests\Integration;

use AmirSasani\GemSystem\Facades\GemService;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GemManagerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        User::factory()->create();
    }

    public function test_gem_service_facade()
    {
        $user = User::latest()->first();

        $gemService = GemService::setUser($user)->increment(10)->decrement(3)->getGem();

        $this->assertEquals(7, $gemService->gem);
    }

    public function test_increment_user_gem()
    {
        $user = User::latest()->first();

        GemService::setUser($user)->increment()->increment(5);

        $this->assertDatabaseHas('gems', [
            'user_id' => $user->id,
            'gem' => 6
        ]);
    }


    public function test_increment_user_gem_transaction()
    {
        $user = User::latest()->first();

        GemService::setUser($user)->increment()->increment(5)->decrement(3);

        $this->assertDatabaseCount('gem_transactions', 3);
    }


    public function test_decrement_user_gem()
    {
        $user = User::latest()->first();

        GemService::setUser($user)->decrement();

        $this->assertDatabaseHas('gems', [
            'user_id' => $user->id,
            'gem' => -1
        ]);
    }


    public function test_decrement_user_gem_transaction()
    {
        $user = User::latest()->first();

        GemService::setUser($user)
            ->decrement()
            ->increment(3)
            ->decrement(2)
            ->decrement(2)
            ->increment(1);

        $this->assertDatabaseCount('gem_transactions', 5);
    }

    public function test_decrement_with_positive_value()
    {
        $user = User::latest()->first();

        GemService::setUser($user)
            ->increment(5)
            ->decrement()
            ->decrement(2)
            ->decrement(-2);

        $this->assertEquals(0, $user->gem->gem);
    }
}
