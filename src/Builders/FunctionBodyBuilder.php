<?php

namespace PHPGen\Builders;

use PHPGen\Parsers\FunctionBodyParser;
use ReflectionFunctionAbstract;
use Stringable;

class FunctionBodyBuilder implements Stringable
{
    protected array $body = [];



    public function __construct(array $body = [])
    {
        $this->body = $body;
    }

    public static function make(array $body = []): static
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
        $r           = implode("\n", array_map(fn ($line) => "{$indentation}{$line}", $this->body));

        return "{\n{$r}\n}";
    }
}
