<?php

namespace PHPGen\Validators;

use ArrayAccess;
use PHPGen\Exceptions\ValidationException;
use PHPGen\Validators\Concerns\CanValidateReservedWords;
use Stringable;

class TypeValidator
{
    use CanValidateReservedWords;



    /**
     * @throws ValidationException
     */
    public static function validate(string $name): void
    {
        if ($name === '') {
            throw new ValidationException('Type cannot be empty string.');
        }

        self::validateReservedWords($name);
    }

    // public function test((Stringable&ArrayAccess)|int $a)
    // {

    // }

    /**
     * @throws ValidationException
     */
    public static function valid(string $name): string
    {
        static::validate($name);

        return $name;
    }
}
