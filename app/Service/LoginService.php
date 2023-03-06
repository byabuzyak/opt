<?php

namespace App\Service;

use App\Dto\LoginDto;
use App\Infrastructure\Auth\AuthManager;
use App\Infrastructure\Exception\UserException;
use App\Repository\UserRepository;

final readonly class LoginService
{
    public function __construct(
        private UserRepository $userRepository,
        private AuthManager $authManager
    ) {
    }

    /**
     * @param LoginDto $credentials
     * @return void
     * @throws UserException
     */
    public function login(LoginDto $credentials): void
    {
        $user = $this->userRepository->findByEmail($credentials->email);
        if (!$user) {
            throw new UserException('User not found');
        }

        if (!$user->getEmailVerifiedAt()) {
            throw new UserException('You must verify your email first');
        }

        if (!password_verify($credentials->password, $user->getPassword())) {
            throw new UserException('Wrong password');
        }

        $this->authManager->login($user);
    }
}