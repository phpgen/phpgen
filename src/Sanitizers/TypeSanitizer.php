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
        // TODO: verify. can ruin tests

        foreach ($value as $conjunctionTypesKey => &$conjunctionTypes) {
            if (is_string($conjunctionTypes)) {
                $conjunctionTypes = [$conjunctionTypes];
            }

            foreach ($conjunctionTypes as $conjunctionTypeKey => $conjunctionType) {
                if (trim($conjunctionType) === '') {
                    unset($value[$conjunctionTypesKey][$conjunctionTypeKey]);
                }
            }

            if (count($value[$conjunctionTypesKey]) === 0) {
                unset($value[$conjunctionTypesKey]);
            }
        }

        return $value;
    }
}
