<?php

namespace PHPGen\Builders\Concerns;

use PHPGen\Sanitizers\NameSanitizer;
use PHPGen\Validators\NameValidator;

trait HasExtends
{
    /**
     * // TODO: It also can contain references to objects such as ClassBuilder?
     */
    protected ?string $extends = null;



    public function extends(?string $extends): static
    {
        if ($extends !== null) {
            $extends = NameValidator::valid(NameSanitizer::sanitize($extends));
        }

        $this->extends = $extends;

        return $this;
    }

    public function getExtends(): ?string
    {
        return $this->extends;
    }
}
