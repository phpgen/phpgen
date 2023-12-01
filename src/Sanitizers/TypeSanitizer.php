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

        foreach ($value as $orKey => &$andList) {
            if (is_string($andList)) {
                $andList = [$andList];
            }

            foreach ($andList as $andKey => $and) {
                if (trim($and) === '') {
                    unset($value[$orKey][$andKey]);
                }
            }

            if (count($value[$orKey]) === 0) {
                unset($value[$orKey]);
            }
        }

        return $value;
    }
}
