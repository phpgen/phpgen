<?php

namespace PHPGen\Builders;

use PHPGen\Builders\Concerns\HasDefaultValue;
use PHPGen\Builders\Concerns\HasName;
use PHPGen\Builders\Concerns\HasReference;
use PHPGen\Builders\Concerns\HasType;
use ReflectionParameter;
use Stringable;

class FunctionParameterBuilder implements Stringable
{
    use HasName;
    use HasReference;
    use HasType;
    use HasDefaultValue;



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
        return static::make($reflection->getName())
            ->type($reflection->getType())
            ->byReference($reflection->isPassedByReference());
    }



    public function __toString(): string
    {
        $reference = $this->isReference() ? '&' : '';

        $result = trim("{$this->getType()} {$reference}\${$this->getName()}");

        if ($this->hasDefaultValue()) {
            $result = "{$result} = {$this->defaultValue}";
        }

        return $result;
    }
}
