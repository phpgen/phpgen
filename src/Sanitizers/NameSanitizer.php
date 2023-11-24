<?php

namespace PHPGen\Sanitizers;

class NameSanitizer
{
    public static function sanitize(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9]+/', '', trim($name, " \n\r\t\v\0\\/"));
    }
}
