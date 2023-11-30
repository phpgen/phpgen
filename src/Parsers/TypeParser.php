<?php

namespace PHPGen\Parsers;

use ParseError;
use PhpToken;

class TypeParser
{
    public static function isValidType(string $type): bool
    {
        if ($type === '') {
            return true;
        }

        try {
            PhpToken::tokenize("<?php function validate ({$type} \$var) {}", TOKEN_PARSE);
            PhpToken::tokenize("<?php class Validate { public {$type} \$var; }", TOKEN_PARSE);

            return true;
        } catch (ParseError) {
            return false;
        }
    }

    /**
     * @return array<array<string>>
     */
    public static function parse(string $type): array
    {
        if (!static::isValidType($type)) {
            throw new \Exception('Unparsable type.');
        }

        if (str_contains($type, '?')) {
            return [['null'], [trim($type, '?')]];
        } else {
            return array_map(function (string $type) {
                return array_map(trim(...), explode('&', trim($type, ' ()')));
            }, explode('|', $type));
        }
    }
}
