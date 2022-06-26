<?php

namespace App\Services\GemManager;

use App\Models\Gem;
use App\Models\User;

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
        $userGem = Gem::firstOrCreate(['user_id' => $this->user->id]);
        $userGem->gem += $amount;
        $userGem->save();

        $userGem->transactions()->create(['amount' => $amount]);

        return $userGem->gem;
    }

    public function decrement(int $amount = 1)
    {
        $userGem = Gem::firstOrCreate(['user_id' => $this->user->id]);
        $userGem->gem -= $amount;
        $userGem->save();

        $userGem->transactions()->create(['amount' => $amount * -1]);

        return $userGem->gem;
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
