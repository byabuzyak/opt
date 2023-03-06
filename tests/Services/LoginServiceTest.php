<?php

namespace Services;

use App\Dto\LoginDto;
use App\Entity\User;
use App\Infrastructure\Auth\AuthManager;
use App\Repository\UserRepository;
use App\Service\LoginService;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LoginServiceTest extends TestCase
{
    /**
     * @return void
     */
    #[Test]
    public function login()
    {
        $service = new LoginService(
            $this->getUserRepositoryMock(),
            $this->getAuthManagerMock()
        );

        $service->login(new LoginDto(email: 'email', password: 'password'));
    }

    /**
     * @return UserRepository|MockObject
     */
    private function getUserRepositoryMock(): UserRepository|MockObject
    {
        $repository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['findByEmail'])
            ->getMock();

        $repository
            ->expects($this->once())
            ->method('findByEmail')
            ->willReturn($this->getUser());

        return $repository;
    }

    /**
     * @return User
     */
    private function getUser(): User
    {
        $user = new User();
        $user->setName('name');
        $user->setEmail('email');
        $user->setPassword(password_hash('password', PASSWORD_BCRYPT));
        $user->setEmailVerifiedAt(new \DateTime());

        return $user;
    }

    /**
     * @return AuthManager
     */
    private function getAuthManagerMock(): AuthManager
    {
        $mock = $this->getMockBuilder(AuthManager::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['login'])
            ->getMock();

        $mock
            ->expects($this->once())
            ->method('login')
            ->with($this->anything());

        return $mock;
    }
}