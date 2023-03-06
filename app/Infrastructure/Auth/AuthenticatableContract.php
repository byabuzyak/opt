<?php

namespace App\Infrastructure\Auth;

interface AuthenticatableContract
{
    /**
     * Get user auth identifier
     * @return string
     */
    public function getAuthIdentifier(): string;

    /**
     * Get the name of auth identifier
     * @return string
     */
    public function getNameIdentifier(): string;
}