<?php

namespace PHPGen\Builders;

use PHPGen\Builders\Concerns\HasName;
use PHPGen\Builders\Concerns\HasVisibility;
use PHPGen\Contracts\BodyMember;
use PHPGen\Enums\Visibility;
use ReflectionProperty;
use Stringable;

class PropertyBuilder implements BodyMember, Stringable
{
    use HasName;
    use HasVisibility;
    // TODO: use HasType;



    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    public static function make(?string $name = null): static
    {
        return new static($name);
    }

    public static function fromReflection(ReflectionProperty $reflection): static
    {
        return static::make($reflection->getName())
            ->visibility(Visibility::tryFromReflection($reflection));
    }



    public function __toString(): string
    {
        return trim("{$this->visibility?->value} \${$this->getName()};");
    }
}