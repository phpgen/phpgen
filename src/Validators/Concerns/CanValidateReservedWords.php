<?php

namespace PHPGen\Validators\Concerns;

use PHPGen\Exceptions\ValidationException;

trait CanValidateReservedWords
{
    /**
     * Reserved PHP words
     * 
     * @see https://github.com/laravel/framework/blob/f0ac18b9b4323e80fb45f81bd47747445e5e885b/src/Illuminate/Console/GeneratorCommand.php#L33
     *
     * @var array<int,string>
     */
    const RESERVED_WORDS = [
        '__halt_compiler',
        'abstract',
        'and',
        'array',
        'as',
        'break',
        'callable',
        'case',
        'catch',
        'class',
        'clone',
        'const',
        'continue',
        'declare',
        'default',
        'die',
        'do',
        'echo',
        'else',
        'elseif',
        'empty',
        'enddeclare',
        'endfor',
        'endforeach',
        'endif',
        'endswitch',
        'endwhile',
        'enum',
        'eval',
        'exit',
        'extends',
        'false',
        'final',
        'finally',
        'fn',
        'for',
        'foreach',
        'function',
        'global',
        'goto',
        'if',
        'implements',
        'include',
        'include_once',
        'instanceof',
        'insteadof',
        'interface',
        'isset',
        'list',
        'match',
        'namespace',
        'new',
        'or',
        'print',
        'private',
        'protected',
        'public',
        'readonly',
        'require',
        'require_once',
        'return',
        'self',
        'static',
        'switch',
        'throw',
        'trait',
        'true',
        'try',
        'unset',
        'use',
        'var',
        'while',
        'xor',
        'yield',
        '__class__',
        '__dir__',
        '__file__',
        '__function__',
        '__line__',
        '__method__',
        '__namespace__',
        '__trait__',
    ];


    
    /**
     * @throws ValidationException
     */
    public static function validateReservedWords(string $word): void
    {
        if (array_key_exists(strtolower($word), array_flip(static::RESERVED_WORDS))) {
            throw new ValidationException("'{$word}' is PHP reserved word.");
        }
    }
}
