<?php

namespace App\Dto;

use App\Infrastructure\Dto\AbstractDto;

class CreateUserDto extends AbstractDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}