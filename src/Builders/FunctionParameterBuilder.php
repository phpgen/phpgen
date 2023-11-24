<?php

namespace PHPGen\Builders;

use PHPGen\Builders\Concerns\HasName;
use ReflectionParameter;
use Stringable;

class FunctionParameterBuilder implements Stringable
{
    use HasName;

    protected ?string $type = null;



    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    public static function make(?string $name = null): static
    {
        return new static($name);
    }

    public static function fromReflection(ReflectionParameter $reflection): static
    {
        // `$reflection->getType()?->getName()` is undocumented, but exists!

        return static::make($reflection->getName())
            ->type($reflection->getType()?->getName());
    }



    public function type(?string $type): static
    {
        $this->type = $type;

        return $this;
    }



    public function __toString(): string
    {
        return trim("{$this->type} \${$this->getName()}");
    }
}
