<?php

namespace PHPGen\Builders\Concerns;

trait HasName
{
    protected ?string $name = null;
    protected ?string $nameHash = null;



    public function name(?string $name): static
    {
        if ($name === '') {
            throw new \Exception('Invalid name.');
        }

        $this->name = $name;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getNameHash(): string
    {
        // TODO: Check for better hash generator. Look how composer done it.
        $this->nameHash ??= 'c' . md5(bin2hex(random_bytes(8)));
        return $this->nameHash;
    }

    public function getNameOrHash(): string
    {
        return $this->name ?? $this->getNameHash();
    }
}
