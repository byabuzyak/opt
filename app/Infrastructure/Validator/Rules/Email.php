<?php

namespace App\Infrastructure\Validator\Rules;

/**
 * This is the basic implementation of email validation
 * On a good note to add more specific validation like RFC check
 */
class Email implements Rule
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @param mixed $data
     * @return bool
     */
    public function isValid(mixed $data): bool
    {
        if (filter_var($data, FILTER_VALIDATE_EMAIL)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return sprintf('Field %s is not a valid email', $this->name);
    }

    /**
     * @param string $name
     * @return void
     */
    public function setFieldName(string $name): void
    {
        $this->name = $name;
    }
}