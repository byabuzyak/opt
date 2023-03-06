<?php

namespace App\Entity;

use App\Infrastructure\Auth\AuthenticatableContract;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'users')]
class User implements AuthenticatableContract
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 4)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: "datetime")]
    private ?\DateTimeInterface $email_verified_at = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string|null $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string|null $password
     */
    public function setPassword(?string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string|null $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * @param string|null $code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getEmailVerifiedAt(): ?\DateTimeInterface
    {
        return $this->email_verified_at;
    }

    /**
     * @param \DateTimeInterface|null $emailVerifiedAt
     */
    public function setEmailVerifiedAt(?\DateTimeInterface $emailVerifiedAt): void
    {
        $this->email_verified_at = $emailVerifiedAt;
    }

    /**
     * @return string
     */
    public function getAuthIdentifier(): string
    {
        return $this->getEmail() ?? '';
    }

    /**
     * @return string
     */
    public function getNameIdentifier(): string
    {
        return 'opt_id';
    }
}