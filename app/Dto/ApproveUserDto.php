<?php

namespace App\Dto;

use App\Infrastructure\Dto\AbstractDto;

class ApproveUserDto extends AbstractDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $code,
    ) {
    }
}