<?php

namespace PHPGen\Builders;

use ReflectionParameter;
use Stringable;

class FunctionParameterBuilder implements Stringable
{
    protected ?string $type = null;
    protected string $name;



    public function __construct(string $name)
    {
        $this->name = $name;
    }
    
    public static function make(string $name): static
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

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    

    public function __toString(): string
    {
        return trim("{$this->type} \${$this->name}");
    }
}
