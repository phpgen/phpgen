<?php

namespace PHPGen\Sanitizers;

class NameSanitizer
{
    public static function sanitize(string $value): string
    {
        return rtrim(trim($value), '\\/');
    }
}
