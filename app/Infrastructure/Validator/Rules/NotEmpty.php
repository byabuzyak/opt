<?php

namespace App\Infrastructure\Validator\Rules;

class NotEmpty implements Rule
{
    /**
     * @var string
     */
    private string $fieldName;

    /**
     * @param mixed $data
     * @return bool
     */
    public function isValid(mixed $data): bool
    {
        if (!empty($data)) {
            return true;
        }

        return false;
    }

    /**
     * @return string
     */
    public function getError(): string
    {
        return sprintf('Field %s must not be empty', $this->fieldName);
    }

    /**
     * @param string $name
     * @return void
     */
    public function setFieldName(string $name): void
    {
        $this->fieldName = $name;
    }
}