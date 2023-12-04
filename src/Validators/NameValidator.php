<?php

namespace PHPGen\Validators;

use PHPGen\Exceptions\ValidationException;
use PHPGen\Validators\Concerns\CanValidateReservedWords;

class NameValidator
{
    use CanValidateReservedWords;



    /**
     * @throws ValidationException
     */
    public static function validate(string $value): void
    {
        if ($value === '') {
            throw new ValidationException('Name cannot be empty string.');
        }

        if (preg_match('/^[_a-zA-Z][_a-zA-Z0-9]*$/', $value) !== 1) {
            throw new ValidationException('Invalid name.');
        }

        self::validateReservedWords($value);
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
