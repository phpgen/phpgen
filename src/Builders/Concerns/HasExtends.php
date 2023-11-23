<?php

namespace PHPGen\Builders\Concerns;

trait HasExtends
{
    /**
     * // TODO: It also can contain references to objects such as ClassBuilder?
     */
    protected ?string $extends = null;



    public function extends(?string $extends): static
    {
        if ($extends === '') {
            throw new \Exception('Invalid extends.');
        }

        $this->extends = $extends;
        return $this;
    }

    public function getExtends(): ?string
    {
        return $this->extends;
    }
}
