<?php

namespace App\Services\GemManager;

use App\Models\Gem;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class GemManager
{
    /**
     * @var User
     */
    private $user;

    /**
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function increment(int $amount = 1)
    {
        return $this->changeAmount($amount);
    }

    public function decrement(int $amount = 1)
    {
        return $this->changeAmount($amount * -1);
    }

    private function changeAmount(int $amount = 1)
    {
        DB::transaction(function () use($amount) {
            $userGem = Gem::lockForUpdate()->firstOrCreate(['user_id' => $this->user->id]);

            $userGem->update(['gem' => DB::raw(sprintf('gem + %d', $amount))]);

            $userGem->transactions()->create(['amount' => $amount]);
        }, 3);

        return true;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }


}
