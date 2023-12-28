<?php

namespace PHPGen\Builders;

use PHPGen\Builders\Concerns\HasBody;
use PHPGen\Builders\Concerns\HasMultipleExtends;
use PHPGen\Builders\Concerns\HasName;
use ReflectionClass;
use Stringable;

class InterfaceBuilder implements Stringable
{
    use HasMultipleExtends;
    use HasName;
    use HasBody;



    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    public static function make(?string $name = null): static
    {
        return new static($name);
    }

    public static function fromReflection(ReflectionClass $reflection): static
    {
        $name = $reflection->isAnonymous() ? null : $reflection->getName();

        return static::make($name);
    }



    public function __toString(): string
    {
        $tab   = 4;
        $space = str_repeat(' ', $tab);

        $methods = '';
        // $methods = implode("\n\n", $this->methods);

        // $methods = implode("\n", array_map(fn ($line) => "{$space}{$line}", explode("\n", $methods)));

        $extends = $this->extends ? 'extends ' . implode(', ', $this->extends) : '';

        return trim("interface {$this->getName()} {$extends}") . "\n{\n{$methods}\n}";
    }
}
