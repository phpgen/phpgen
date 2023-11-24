<?php

namespace PHPGen\Builders\Concerns;

use PHPGen\Sanitizers\NameSanitizer;
use PHPGen\Validators\NameValidator;

trait HasName
{
    protected ?string $name     = null;
    protected ?string $nameHash = null;



    public function name(?string $name): static
    {
        if ($name !== null) {
            $name = NameValidator::valid(NameSanitizer::sanitize($name));
        }

        $this->name = $name;

        return $this;
    }

    public function getName(): string
    {
        return $this->name ?? $this->getNameHash();
    }

    protected function getNameHash(): string
    {
        // TODO: Check for better hash generator. Look how composer done it.
        $this->nameHash ??= 'phpgen_' . md5(bin2hex(random_bytes(8)));

        return $this->nameHash;
    }
}
