<?php

namespace PHPGen\Builders;

use PHPGen\Builders\Concerns\HasVisibility;
use PHPGen\Contracts\BodyMember;
use PHPGen\Enums\Visibility;
use ReflectionFunctionAbstract;

class MethodBuilder extends FunctionBuilder implements BodyMember
{
    use HasVisibility;



    /**
     * Create new instance from reflection.
     */
    public static function fromReflection(ReflectionFunctionAbstract $reflection): static
    {
        return parent::fromReflection($reflection)
            ->visibility(Visibility::tryFromReflection($reflection));
    }

    /**
     * Create new instance from FunctionBuilder.
     */
    public static function fromFunctionBuilder(FunctionBuilder $function): static
    {
        return static::make($function->getName())
            ->parameters($function->getParameters())
            ->return($function->getReturn())
            ->body($function->getBody());
    }



    public function __toString(): string
    {
        $result = parent::__toString();

        return trim("{$this->visibility?->value} {$result}", ' ');
    }
}
