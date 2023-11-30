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
        array_walk($value, function (string|array &$types, $key) use (&$value): void {
            if (is_string($types)) {
                $types = [$types];
            } elseif (count($types) === 0) {
                unset($value[$key]);
            }
            // TODO: Filter '' and other shit
        });

        // foreach ($value as $key => $types) {
        //     if (is_string($types)) {

        //     }
        //     elseif (is_array()) {

        //     }
        // }

        return $value;
    }
}
