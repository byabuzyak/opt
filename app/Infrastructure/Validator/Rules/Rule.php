<?php

namespace App\Infrastructure\Validator\Rules;

/**
 * Basic implementation of Rule validator
 */
interface Rule
{
    /**
     * @param mixed $data
     * @return bool
     */
    public function isValid(mixed $data): bool;

    /**
     * @return string
     */
    public function getError(): string;

    /**
     * @param string $name
     * @return void
     */
    public function setFieldName(string $name): void;
}