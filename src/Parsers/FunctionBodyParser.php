<?php

namespace PHPGen\Parsers;

use PHPGen\Exceptions\ParseException;
use PhpToken;
use ReflectionFunctionAbstract;
use SplFileObject;

class FunctionBodyParser
{
    const T_CURLY_OPEN  = 123;
    const T_CURLY_CLOSE = 125;

    public static function parse(ReflectionFunctionAbstract $reflection): array
    {
        // We assume that source code of reflected function can not be invalid.
        // Since it must be compiled before passed to reflection constructor.
        // So there no need of parsing it with TOKEN_PARSE.

        $source = static::getSource($reflection);
        $tokens = static::tryTokenize($source);


        $braces = static::filterOnlyCurlyBracesTokens($tokens);
        $count  = 0;
        $start  = 0;
        $end    = 0;

        foreach ($braces as $brace) {
            if ($brace->id === static::T_CURLY_CLOSE) {
                if (--$count === 0) {
                    $end = $brace->pos;
                    break;
                }
            }
            elseif ($count++ === 0) {
                $start = $brace->pos;
            }
        }

        $fromStartToEndBrace      = substr($source, 0, $end + 1);
        $fromStartBraceToEndBrace = substr($fromStartToEndBrace, $start);
        $rawBody                  = trim($fromStartBraceToEndBrace, '{}');

        if (trim($rawBody) === '') {
            return [];
        }

        $body = explode("\n", $rawBody);
        $size = count($body);

        if ($size > 0) {
            if (trim($body[$size - 1], "} \n\r\t\v\0") === '') {
                array_pop($body);
            }
            if (trim($body[0], "{ \n\r\t\v\0") === '') {
                array_shift($body);
            }
        }

        return $body;
    }



    protected static function getSource(ReflectionFunctionAbstract $reflection): string
    {
        $lines  = static::getSourceLines($reflection);
        $string = implode("\n", $lines);

        return "<?php {$string}";
    }

    protected static function getSourceLines(ReflectionFunctionAbstract $reflection): array
    {
        $startLine  = max($reflection->getStartLine() - 1, 0);
        $endLine    = $reflection->getEndLine();
        $linesCount = $endLine - $startLine;

        $file = new SplFileObject($reflection->getFileName());
        $file->seek($startLine);

        $lines = [];
        while ($linesCount-- > 0) {
            $lines[] = rtrim($file->fgets());
        }

        return $lines;
    }



    /**
     * @param array<int,\PhpToken> $tokens
     *
     * @return array<int,\PhpToken>
     */
    protected static function filterOnlyCurlyBracesTokens(array $tokens): array
    {
        // TODO: Check if array_key_exists will be more performant?
        return array_filter($tokens, fn (PhpToken $token): bool => (
            $token->id    === T_CURLY_OPEN
            || $token->id === static::T_CURLY_OPEN
            || $token->id === static::T_CURLY_CLOSE
        ));
    }



    /**
     * @return array<int,\PhpToken>
     */
    protected static function tryTokenize(string $source): array
    {
        $tokens = PhpToken::tokenize($source);

        static::validateTokens($tokens);

        return $tokens;
    }

    /**
     * @param array<int,\PhpToken> $tokens
     *
     * @throws ParseException
     */
    protected static function validateTokens(array $tokens): void
    {
        $functionLine = null;

        foreach ($tokens as $token) {
            if ($token->isIgnorable()) {
                continue;
            }

            if ($token->is(T_FUNCTION)) {
                if ($functionLine === $token->line) {
                    throw new ParseException('Parser is unable to parse multiple functions which are defined on the same lines.');
                }

                $functionLine = $token->line;
            }
        }

        if ($functionLine === null) {
            throw new ParseException('Parser did not recognize the function.');
        }
    }
}
