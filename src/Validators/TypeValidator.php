<?php

namespace PHPGen\Validators;

use PHPGen\Exceptions\ValidationException;
use PHPGen\Validators\Concerns\CanValidateReservedWords;

class TypeValidator
{
    use CanValidateReservedWords;



    /**
     * Validate
     *
     * @param array<array<string>> $value
     *
     * @throws ValidationException
     */
    public static function validate(array &$value): void
    {
        try {
            foreach ($value as $andList) {
                foreach ($andList as $and) {
                    if (preg_match('/[()|&]/', $and) === 1) {
                        throw new ValidationException('Invalid character in type definition.');
                    }
                }
            }
        }
        catch (ValidationException $e) {
            throw $e;
        }
        catch (\Throwable) {
            throw new ValidationException('Invalid type definition.');
        }
    }

    /**
     * Validate and return original value
     *
     * @return array<array<string>>
     *
     * @throws ValidationException
     */
    public static function &valid(array &$value): array
    {
        static::validate($value);

        return $value;
    }
}
