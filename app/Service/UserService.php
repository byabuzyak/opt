<?php

namespace App\Service;

use App\Dto\ApproveUserDto;
use App\Dto\CreateUserDto;
use App\Entity\User;
use App\Infrastructure\Exception\UserException;
use App\Notification\SignupSuccessNotification;
use App\Notification\VerifyNotification;
use App\Repository\UserRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

final readonly class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository->attach(new VerifyNotification(), 'user::created');
        $this->userRepository->attach(new SignupSuccessNotification(), 'user::approved');
    }

    /**
     * @param CreateUserDto $userData
     * @return User
     * @throws UniqueConstraintViolationException
     */
    public function createUser(CreateUserDto $userData): User
    {
        return $this->userRepository->createUser($userData);
    }

    /**
     * @param ApproveUserDto $userDto
     * @return User
     * @throws UserException
     */
    public function approveUser(ApproveUserDto $userDto): User
    {
        return $this->userRepository->approveUser($userDto);
    }
}