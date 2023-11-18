<?php

namespace PHPGen\Builders;

use PHPGen\Contracts\Exportable;
use ReflectionParameter;

class FunctionParameterBuilder implements Exportable
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

    public static function fromReflection(ReflectionParameter $parameter): static
    {
        return static::make($parameter->getName())->type($parameter->getType()?->getName());
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

    public function toArray(): array
    {
        return [];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
