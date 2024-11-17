<?php

namespace Framework\Rules;

use Framework\Contracts\RuleInterface;

class LengthMaxRule implements RuleInterface
{
    public function validate(array $data, string $field, array $params): bool
    {
        if (empty($params[0])) {
            throw new \InvalidArgumentException("Length max not specified");
        }

        return strlen($data[$field]) < (int) $params[0];
    }

    public function getMessage(array $data, string $field, array $params): string
    {
        return "Field {$field} must be less than or equal to {$params[0]}";
    }
}
