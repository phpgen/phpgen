<?php

namespace PHPGen\Builders;

use PHPGen\Parsers\FunctionBodyParser;
use ReflectionFunctionAbstract;
use Stringable;

class FunctionBodyBuilder implements Stringable
{
    protected ?string $body = null;



    public function __construct(?string $body = null)
    {
        $this->body = $body;
    }

    public static function make(?string $body = null): static
    {
        return new static($body);
    }

    public static function fromReflection(ReflectionFunctionAbstract $reflection): static
    {
        $body = FunctionBodyParser::parse($reflection);

        return static::make($body);
    }



    public function __toString(): string
    {
        $indentation = '    ';
        $r           = implode("\n", array_map(fn ($line) => "{$indentation}{$line}", explode("\n", $this->body)));

        return "{\n{$r}\n}";
    }
}
