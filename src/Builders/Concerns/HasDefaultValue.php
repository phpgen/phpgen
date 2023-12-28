<?php

namespace PHPGen\Builders\Concerns;

trait HasDefaultValue
{
    protected ?string $defaultValue = null;



    public function defaultValue(?string $defaultValue): static
    {
        $this->defaultValue = $defaultValue;

        return $this;
    }

    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    public function hasDefaultValue(): bool
    {
        return !$this->hasNoDefaultValue();
    }

    public function hasNoDefaultValue(): bool
    {
        return $this->defaultValue === null;
    }
}
