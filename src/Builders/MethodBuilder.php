<?php

namespace PHPGen\Builders;

use PHPGen\Enums\MethodVisibility;
use ReflectionFunctionAbstract;

class MethodBuilder extends FunctionBuilder
{
    protected ?MethodVisibility $visibility = null;



    /**
     * Create new instance from reflection.
     */
    public static function fromReflection(ReflectionFunctionAbstract $reflection): static
    {
        return parent::fromReflection($reflection)
            ->visibility(MethodVisibility::tryFromReflection($reflection));
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



    public function visibility(?MethodVisibility $visibility): static
    {
        $this->visibility = $visibility;
        return $this;
    }

    public function public(): static
    {
        $this->visibility = MethodVisibility::Public;
        return $this;
    }

    public function protected(): static
    {
        $this->visibility = MethodVisibility::Protected;
        return $this;
    }

    public function private(): static
    {
        $this->visibility = MethodVisibility::Private;
        return $this;
    }

    

    public function __toString(): string
    {
        $result = parent::__toString();
        
        return trim("{$this->visibility?->value} {$result}", ' ');
    }
}
