<?php

namespace PHPGen\Builders;
use PHPGen\Enums\MethodVisibility;

class MethodBuilder extends FunctionBuilder
{
    protected ?MethodVisibility $visibility = null;



    /**
     * Create new instance from FunctionBuilder instance
     */
    public static function fromFunctionBuilder(FunctionBuilder $function): static
    {
        $that = new static($function->getName());
        $that->parameters = $function->getParameters();
        $that->return = $function->getReturn();
        $that->body = $function->getBody();

        return $that;
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

    public function toArray(): array
    {
        // TODO

        return [];
    }
}
