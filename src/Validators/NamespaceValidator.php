<?php

namespace PHPGen\Validators;

use PHPGen\Exceptions\ValidationException;

class NamespaceValidator
{
    /**
     * @throws ValidationException
     */
    public static function validate(string $value): void
    {
        if ($value === '') {
            throw new ValidationException('Namespace cannot be empty string.');
        }

        if (preg_match('/^(?:[a-zA-Z_][a-zA-Z0-9_]*)(?:\\\\[a-zA-Z_][a-zA-Z0-9_]*)*$/', $value) !== 1) {
            throw new ValidationException('Invalid namespace.');
        }
    }

    /**
     * @throws ValidationException
     */
    public static function valid(string $value): string
    {
        static::validate($value);

        return $value;
    }
}
