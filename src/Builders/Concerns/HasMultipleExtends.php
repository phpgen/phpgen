<?php

namespace PHPGen\Builders\Concerns;

use PHPGen\Sanitizers\NameSanitizer;
use PHPGen\Validators\NameValidator;

trait HasMultipleExtends
{
    /**
     * // TODO: It also can contain references to objects such as ClassBuilder?
     * @var array<int,string>
     */
    protected array $extends = [];



    /**
     * @param array<int,string> $extends
     */
    public function extends(array $extends): static
    {
        return $this->flushExtends()->addExtends($extends);
    }

    /**
     * @param string|array<int,string> $extends
     */
    public function addExtends(string|array $extends): static
    {
        if (is_string($extends)) {
            $extends = [$extends];
        }

        array_walk($extends, function (string $extend) {
            $this->extends[] = NameValidator::valid(NameSanitizer::sanitize($extend));
        });

        return $this;
    }

    /**
     * @return array<int,string>
     */
    public function getExtends(): array
    {
        return $this->extends;
    }

    public function flushExtends(): static
    {
        $this->extends = [];

        return $this;
    }
}
