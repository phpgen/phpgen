<?php

namespace PHPGen\Builders\Concerns;

trait HasReference
{
    protected bool $isReference = false;



    public function byReference(bool $byReference = true): static
    {
        $this->isReference = $byReference;

        return $this;
    }

    public function byRef(bool $byRef = true): static
    {
        return $this->byReference($byRef);
    }

    public function isReference(): bool
    {
        return $this->isReference;
    }

    public function isRef(): bool
    {
        return $this->isReference();
    }
}
