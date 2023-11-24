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
    public static function validate(string $name): void
    {
        if ($name === '') {
            throw new ValidationException('Name cannot be empty string.');
        }

        if (preg_match('/^[a-zA-Z]/', $name) !== 1) {
            throw new ValidationException('Name only can start with alpha character.');
        }

        self::validateReservedWords($name);
    }

    /**
     * @throws ValidationException
     */
    public static function valid(string $name): string
    {
        static::validate($name);

        return $name;
    }
}
