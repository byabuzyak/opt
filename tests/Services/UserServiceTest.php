<?php

namespace Services;

use App\Dto\ApproveUserDto;
use App\Dto\CreateUserDto;
use App\Repository\UserRepository;
use App\Service\UserService;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Constraint\IsType;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    /**
     * @return void
     * @throws UniqueConstraintViolationException
     */
    #[Test]
    public function createUser(): void
    {
        $userRepository = $this->getUserRepositoryMock();
        $userRepository
            ->expects($this->once())
            ->method('createUser');

        $userService = new UserService($userRepository);
        $userService->createUser(new CreateUserDto(name: 'Name', email: 'email', password: 'password'));
    }

    /**
     * @throws \Exception
     */
    #[Test]
    public function approveUser()
    {
        $userRepository = $this->getUserRepositoryMock();
        $userRepository
            ->expects($this->once())
            ->method('approveUser');

        $userService = new UserService($userRepository);
        $userService->approveUser(new ApproveUserDto(email: 'email', code: 1234));
    }

    /**
     * @return UserRepository|MockObject
     */
    private function getUserRepositoryMock(): UserRepository|MockObject
    {
        $userRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['attach', 'createUser', 'approveUser'])
            ->getMock();

        $userRepository
            ->expects($this->exactly(2))
            ->method('attach')
            ->with(
                $this->isType(IsType::TYPE_OBJECT),
                $this->isType(IsType::TYPE_STRING),
            );

        return $userRepository;
    }
}