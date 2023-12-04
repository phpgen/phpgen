<?php

namespace PHPGen\Builders\Concerns;

use PHPGen\Builders\TypeBuilder;

use function PHPGen\buildType;

trait HasType
{
    protected ?TypeBuilder $type = null;



    public function type(null|string|array|object $type = null): static
    {
        $this->type = $type instanceof TypeBuilder ? $type : buildType($type);

        return $this;
    }

    public function getType(): TypeBuilder
    {
        return $this->type ??= TypeBuilder::make();
    }
}
