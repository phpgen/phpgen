<?php

namespace PHPGen\Sanitizers;

class NameSanitizer
{
    public static function sanitize(string $name): string
    {
        return str_replace(' ', '', trim($name, " \n\r\t\v\0\\/"));
    }
}
