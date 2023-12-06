<?php

namespace PHPGen\Builders\Concerns;

use PHPGen\Builders\BodyBuilder;

trait HasBody
{
    protected ?BodyBuilder $body = null;



    /**
     * @internal
     */
    public function body(BodyBuilder $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getBody(): BodyBuilder
    {
        return $this->body ??= BodyBuilder::make();
    }


    /**
     * @param array<int,string|MethodBuilder|ReflectionMethod> $methods
     */
    public function methods(array $methods): static
    {
        $this->getBody()->methods($methods);

        return $this;
    }

    /**
     * @param string|array<int,string|MethodBuilder|ReflectionMethod> $methods
     */
    public function addMethods(string|array $methods): static
    {
        $this->getBody()->addMethods($methods);

        return $this;
    }

    /**
     * @return array<MethodBuilder>
     */
    public function getMethods(?callable $callback = null): array
    {
        $this->getBody()->getMethods($callback);

        return $this;
    }

    public function flushMethods(): static
    {
        $this->getBody()->flushMethods();

        return $this;
    }



    /**
     * @param array<int,string|PropertyBuilder|ReflectionProperty> $methods
     */
    public function properties(array $properties): static
    {
        $this->getBody()->properties($properties);

        return $this;
    }

    /**
     * @param string|array<int,string|PropertyBuilder|ReflectionProperty> $methods
     */
    public function addProperties(string|array $properties): static
    {
        $this->getBody()->addProperties($properties);

        return $this;
    }

    /**
     * @return array<PropertyBuilder>
     */
    public function getProperties(?callable $callback = null): array
    {
        $this->getBody()->getProperties($callback);

        return $this;
    }

    public function flushProperties(): static
    {
        $this->getBody()->flushProperties();

        return $this;
    }
}
