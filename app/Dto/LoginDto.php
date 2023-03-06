<?php

namespace App\Dto;

use App\Infrastructure\Dto\AbstractDto;

class LoginDto extends AbstractDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}