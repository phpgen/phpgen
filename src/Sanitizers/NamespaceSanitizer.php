<?php

namespace PHPGen\Sanitizers;

class NamespaceSanitizer
{
    public static function sanitize(string $value): string
    {
        $namespace = trim($value, " \n\r\t\v\0\\/");
        $namespace = str_replace('/', '\\', $namespace);

        return $namespace;
    }
}
