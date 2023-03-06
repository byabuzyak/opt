<?php

namespace App\Infrastructure\Auth;

use Symfony\Component\HttpFoundation\Session\Session;

class AuthManager
{
    public function __construct(private readonly Session $session)
    {
    }

    /**
     * @param AuthenticatableContract $user
     * @return void
     */
    public function login(AuthenticatableContract $user): void
    {
        $this->session->set($user->getNameIdentifier(), $user->getAuthIdentifier());
    }
}