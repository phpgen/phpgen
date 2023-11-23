<?php

namespace PHPGen\Builders\Concerns;

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
        $this->implements = array_filter($implements, fn (string $implement) => (bool) $implement);
        
        return $this;
    }

    /**
     * @return array<int,string>
     */
    public function getImplements(): array
    {
        return $this->implements;
    }
}
