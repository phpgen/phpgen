<?php

namespace PHPGen\Parsers;

use ParseError;
use PHPGen\Exceptions\ParseException;
use PhpToken;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use SplFileObject;

class FunctionBodyParser
{
    public static function parse(ReflectionFunctionAbstract $reflection): string
    {
        $isMethod = $reflection instanceof ReflectionMethod;

        $functionStartLine  = max($reflection->getStartLine() - 1, 0);
        $functionEndLine    = $reflection->getEndLine();
        $functionLinesCount = $functionEndLine - $functionStartLine;

        $file = new SplFileObject($reflection->getFileName());
        $file->seek($functionStartLine);

        $functionLines = [];
        while ($functionLinesCount-- > 0) {
            $functionLines[] = rtrim($file->fgets());
        }

        $function = implode("\n", $functionLines);

        $offset = $isMethod ? 7 : 2;
        $source = $isMethod ? "<?php class T {{$function}}" : "<?php {$function}";

        $tokens = array_slice(static::tryTokenize($source), $offset);

        $body         = '';
        $braceCount   = 0;
        $insideString = false;

        for ($i = 0; $i < count($tokens); $i++) {
            $token = $tokens[$i];

            if ($token->is('"')) {
                $insideString = !$insideString;
                $body .= $token->text;
                continue;
            }

            if ($insideString) {
                $body .= $token->text;
                continue;
            }

            if ($token->is('{')) {
                $braceCount++;

                if ($braceCount === 1) {
                    // Skip first "\n" character if it presented
                    for ($j = $i + 1; $j < count($tokens); $j++) {
                        $furtherToken = $tokens[$j];

                        if (!$furtherToken->is(T_WHITESPACE)) {
                            break;
                        }

                        if (str_contains($furtherToken->text, "\n")) {
                            $body .= preg_replace('/\n/', '', $furtherToken->text, 1);
                            $i = $j;
                            break;
                        }
                    }

                    continue;
                }
            }
            elseif ($token->is('}')) {
                $braceCount--;

                if ($braceCount === 0) {
                    break;
                }
            }

            if ($braceCount > 0) {
                $body .= $token->text;
                continue;
            }
        }

        return $body;
    }



    /**
     * @return array<\PhpToken>
     */
    protected static function tryTokenize(string $source): array
    {
        try {
            $tokens = PhpToken::tokenize($source);

            static::validateTokens($tokens);

            return $tokens;
        }
        catch (ParseError $e) {
            if (str_starts_with($e->getMessage(), 'Unclosed')) {
                throw new ParseException('Parser is unable to parse multiple functions which are defined on the same lines.');
            }

            throw $e;
        }
    }

    /**
     * @param array<\PhpToken> $tokens
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

            if ($token->is(T_FUNCTION) || $token->is(T_FN)) {
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
