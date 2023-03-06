<?php

namespace App\Infrastructure\Validator;

use App\Infrastructure\Validator\Rules\Rule;

class Validator
{
    /**
     * @var array
     */
    protected array $rules = [];

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var array
     */
    protected array $errors = [];

    /**
     * @param array $rules
     * @param array $data
     * @return array
     * @throws InvalidRuleException
     */
    public function validate(array $rules, array $data): array
    {
        $this->rules = $rules;
        $this->data = $data;

        return $this->passes();
    }

    /**
     * @return array
     * @throws InvalidRuleException
     */
    private function passes(): array
    {
        foreach ($this->rules as $attribute => $rules) {
            foreach ($rules as $rule) {
                if (!$rule instanceof Rule) {
                    throw new InvalidRuleException('Invalid rule');
                }

                $rule->setFieldName($attribute);
                if (!$rule->isValid($this->data[$attribute])) {
                    $this->errors[$attribute] = $rule->getError();
                }
            }
        }

        return $this->errors;
    }
}