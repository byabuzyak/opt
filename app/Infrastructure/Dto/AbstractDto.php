<?php

namespace App\Infrastructure\Dto;

/**
 * The simplest implementation of DTO
 */
abstract class AbstractDto
{
    /**
     * @param mixed $args
     * @return static
     */
    public static function fromArray(mixed $args): static
    {
        return new static(...$args);
    }
}