<?php

namespace PHPGen\Builders;

use PHPGen\Builders\Concerns\HasDefaultValue;
use PHPGen\Builders\Concerns\HasName;
use PHPGen\Builders\Concerns\HasType;
use PHPGen\Builders\Concerns\HasVisibility;
use PHPGen\Contracts\BodyMember;
use PHPGen\Enums\Visibility;
use ReflectionProperty;
use Stringable;

class PropertyBuilder implements BodyMember, Stringable
{
    use HasDefaultValue;
    use HasName;
    use HasType;
    use HasVisibility;



    public function __construct(?string $name = null)
    {
        $this->name($name);
    }

    public static function make(?string $name = null): static
    {
        return new static($name);
    }

    public static function fromReflection(ReflectionProperty $reflection): static
    {
        return static::make($reflection->getName())
            ->visibility(Visibility::tryFromReflection($reflection))
            ->type($reflection->getType());
    }



    public function __toString(): string
    {
        $result = trim("{$this->getType()} \${$this->getName()}");

        if ($this->hasDefaultValue()) {
            $result = "{$result} = {$this->defaultValue}";
        }

        return "{$result};";
    }
}
