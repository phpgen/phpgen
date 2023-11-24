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




    /**
     * @throws ValidationException
     */
    public static function validateReservedWords(string $word): void
    {
        $reservedWords = [
            '__halt_compiler' => 0,
            'abstract'        => 0,
            'and'             => 0,
            'array'           => 0,
            'as'              => 0,
            'break'           => 0,
            'callable'        => 0,
            'case'            => 0,
            'catch'           => 0,
            'class'           => 0,
            'clone'           => 0,
            'const'           => 0,
            'continue'        => 0,
            'declare'         => 0,
            'default'         => 0,
            'die'             => 0,
            'do'              => 0,
            'echo'            => 0,
            'else'            => 0,
            'elseif'          => 0,
            'empty'           => 0,
            'enddeclare'      => 0,
            'endfor'          => 0,
            'endforeach'      => 0,
            'endif'           => 0,
            'endswitch'       => 0,
            'endwhile'        => 0,
            'enum'            => 0,
            'eval'            => 0,
            'exit'            => 0,
            'extends'         => 0,
            'false'           => 0,
            'final'           => 0,
            'finally'         => 0,
            'fn'              => 0,
            'for'             => 0,
            'foreach'         => 0,
            'function'        => 0,
            'global'          => 0,
            'goto'            => 0,
            'if'              => 0,
            'implements'      => 0,
            'include'         => 0,
            'include_once'    => 0,
            'instanceof'      => 0,
            'insteadof'       => 0,
            'interface'       => 0,
            'isset'           => 0,
            'list'            => 0,
            'match'           => 0,
            'namespace'       => 0,
            'new'             => 0,
            'or'              => 0,
            'print'           => 0,
            'private'         => 0,
            'protected'       => 0,
            'public'          => 0,
            'readonly'        => 0,
            'require'         => 0,
            'require_once'    => 0,
            'return'          => 0,
            'self'            => 0,
            'static'          => 0,
            'switch'          => 0,
            'throw'           => 0,
            'trait'           => 0,
            'true'            => 0,
            'try'             => 0,
            'unset'           => 0,
            'use'             => 0,
            'var'             => 0,
            'while'           => 0,
            'xor'             => 0,
            'yield'           => 0,
            '__class__'       => 0,
            '__dir__'         => 0,
            '__file__'        => 0,
            '__function__'    => 0,
            '__line__'        => 0,
            '__method__'      => 0,
            '__namespace__'   => 0,
            '__trait__'       => 0,
        ];

        if (array_key_exists(strtolower($word), $reservedWords)) {
            throw new ValidationException("'{$word}' is PHP reserved word.");
        }
    }
}
