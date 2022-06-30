<?php

namespace Tests\Integration;

use App\Models\User;
use App\Services\GemManager\GemManager;
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

    public function test_increment_user_gem()
    {
        $user = User::latest()->first();

        $gemManager = new GemManager($user);

        $gemManager->increment();
        $gemManager->increment(5);

        $this->assertDatabaseHas('gems', [
            'user_id' => $user->id,
            'gem' => 6
        ]);
    }

    /**
     * @depends test_increment_user_gem
     */
    public function test_increment_user_gem_transaction()
    {
        $user = User::latest()->first();

        $gemManager = new GemManager($user);

        $gemManager->increment();
        $gemManager->increment(5);
        $gemManager->decrement(3);


        $this->assertDatabaseCount('gem_transactions', 3);
    }

    /**
     * @depends test_increment_user_gem_transaction
     */
    public function test_decrement_user_gem()
    {
        $user = User::latest()->first();

        $gemManager = new GemManager($user);

        $gemManager->decrement();

        $this->assertDatabaseHas('gems', [
            'user_id' => $user->id,
            'gem' => -1
        ]);
    }

    /**
     * @depends test_decrement_user_gem
     */
    public function test_decrement_user_gem_transaction()
    {
        $user = User::latest()->first();

        $gemManager = new GemManager($user);

        $gemManager->decrement();
        $gemManager->increment(3);
        $gemManager->decrement(2);
        $gemManager->decrement(2);
        $gemManager->increment(1);

        $this->assertDatabaseCount('gem_transactions', 5);
    }
}
