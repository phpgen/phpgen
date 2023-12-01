<?php

namespace PHPGen\Sanitizers;

class TypeSanitizer
{
    /**
     * @param array<string|array<string>> $value
     *
     * @return array<array<string>>
     */
    public static function &sanitize(array &$value): array
    {
        foreach ($value as $typesKey => $types) {
            if (is_string($value[$typesKey])) {
                $value[$typesKey] = [$types];
            }

            foreach ($value[$typesKey] as $typeKey => $type) {
                if (trim($type) === '') {
                    unset($value[$typesKey][$typeKey]);
                }
            }

            if (count($value[$typesKey]) === 0) {
                unset($value[$typesKey]);
            }
        }

        return $value;
    }
}
