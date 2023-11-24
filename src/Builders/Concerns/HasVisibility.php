<?php

namespace PHPGen\Builders\Concerns;

use PHPGen\Enums\Visibility;

trait HasVisibility
{
    protected ?Visibility $visibility = null;



    public function visibility(?Visibility $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function public(): static
    {
        $this->visibility = Visibility::Public;

        return $this;
    }

    public function protected(): static
    {
        $this->visibility = Visibility::Protected;

        return $this;
    }

    public function private(): static
    {
        $this->visibility = Visibility::Private;

        return $this;
    }
}
