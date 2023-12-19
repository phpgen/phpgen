<?php

namespace PHPGen\Builders\Concerns;

use PHPGen\Sanitizers\NamespaceSanitizer;
use PHPGen\Validators\NamespaceValidator;

trait HasNamespace
{
    protected ?string $namespace = null;



    public function namespace(?string $namespace): static
    {
        if ($namespace !== null) {
            $namespace = NamespaceValidator::valid(NamespaceSanitizer::sanitize($namespace));
        }

        $this->namespace = $namespace;

        return $this;
    }

    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    public function hasNamespace(): bool
    {
        return $this->namespace !== null;
    }

    public function hasNoNamespace(): bool
    {
        return !$this->hasNamespace();
    }



    /**
     * @return array{null|string,string}
     */
    protected function splitIntoNamespaceAndName(string $namespace): array
    {
        $parts = explode('\\', $namespace);
        
        if (count($parts) === 1) {
            $namespace = null;
            $name  = $parts[0];
        }
        else {
            $name  = array_pop($parts);
            $namespace = implode('\\', $parts);
        }

        return [$namespace, $name];
    }
}
