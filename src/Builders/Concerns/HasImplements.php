<?php

namespace PHPGen\Builders\Concerns;

use PHPGen\Sanitizers\NameSanitizer;
use PHPGen\Validators\NameValidator;

trait HasImplements
{
    /**
     * // TODO: FEAT: It also can contain references to objects such as ClassBuilder?
     * @var array<int,string>
     */
    protected array $implements = [];



    /**
     * @param array<int,string> $implements
     */
    public function implements(array $implements): static
    {
        return $this->flushImplements()->addImplements($implements);
    }

    /**
     * @param string|array<int,string> $implements
     */
    public function addImplements(string|array $implements): static
    {
        if (is_string($implements)) {
            $implements = [$implements];
        }

        array_walk($implements, function (string $implement) {
            $this->implements[] = NameValidator::valid(NameSanitizer::sanitize($implement));
        });

        return $this;
    }

    /**
     * @return array<int,string>
     */
    public function getImplements(): array
    {
        return $this->implements;
    }

    public function flushImplements(): static
    {
        $this->implements = [];

        return $this;
    }
}
