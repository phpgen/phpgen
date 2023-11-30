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
     * @param array $value Expects array<array<string>>
     *
     * @throws ValidationException
     */
    public static function validate(array &$value): void
    {
        try {
            foreach ($value as $types) {
                foreach ($types as $type) {
                    if (preg_match('/[()|&]/', $type) === 1) {
                        throw new ValidationException('Invalid character in type definition.');
                    }
                }
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Throwable) {
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
