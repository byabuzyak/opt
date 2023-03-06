<?php

namespace App\Repository;

use App\Dto\ApproveUserDto;
use App\Dto\CreateUserDto;
use App\Entity\User;
use App\Infrastructure\Exception\UserException;
use App\Infrastructure\Repository\BaseRepository;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class UserRepository extends BaseRepository
{
    /**
     * @param CreateUserDto $userData
     * @return User
     * @throws UniqueConstraintViolationException
     */
    public function createUser(CreateUserDto $userData): User
    {
        $user = new User();
        $user->setName($userData->name);
        $user->setEmail($userData->email);
        $user->setPassword(password_hash($userData->password, PASSWORD_BCRYPT));
        $user->setCode(mt_rand(1000, 9999));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->notify('user::created', $user);

        return $user;
    }

    /**
     * @param ApproveUserDto $userDto
     * @return User
     * @throws UserException
     */
    public function approveUser(ApproveUserDto $userDto): User
    {
        /** @var User $user */
        $user = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $userDto->email]);

        if (!$user || $user->getEmailVerifiedAt()) {
            throw new UserException('This user is already verified or does not exist');
        }

        if ($user->getCode() !== $userDto->code) {
            throw new UserException('Wrong code');
        }

        $user->setEmailVerifiedAt(new \DateTime());
        $this->entityManager->persist($user);
        $this->entityManager->flush($user);

        $this->notify('user::approved', $user);

        return $user;
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this
            ->entityManager
            ->getRepository(User::class)
            ->findOneBy(['email' => $email]);
    }
}