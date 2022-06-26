<?php

namespace App\Services\GemManager;

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
        $this->user->gem()->increment('gem', $amount);
        return $this->user->gem->gem;
    }

    public function decrement(int $amount = 1)
    {
        $this->user->gem()->decrement('gem', $amount);
        return $this->user->gem->gem;
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
