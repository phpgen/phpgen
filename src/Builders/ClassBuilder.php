<?php

namespace PHPGen\Builders;

use ReflectionClass;
use ReflectionMethod;
use Stringable;

class ClassBuilder implements Stringable
{
    protected string $name;

    protected bool $isFinal = false;

    protected bool $isAbstract = false;

    protected array $methods = [];



    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Create new instance
     */
    public static function make(string $name): static
    {
        return new static($name);
    }

    /**
     * Create new instance from reflection
     */
    public static function fromReflection(ReflectionClass $reflection): static
    {
        return static::make($reflection->getName())
            ->final($reflection->isFinal())
            ->abstract($reflection->isAbstract())
            ->methods($reflection->getMethods());
    }

    /**
     * Create new instance from anonymous class
     */
    public static function fromAnonymous(string $name, object $anonymous): static
    {
        $reflection = new ReflectionClass($anonymous);

        return static::fromReflection($reflection)
            ->name($name);
    }



    /**
     * Set name
     */
    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     */
    public function getName(): string
    {
        return $this->name;
    }


    public function final(bool $final = true): static
    {
        $this->isFinal = $final;
        return $this;
    }

    public function isFinal(): bool
    {
        return $this->isFinal;
    }


    public function abstract(bool $abstract = true): static
    {
        $this->isAbstract = $abstract;
        return $this;
    }

    public function isAbstract(): bool
    {
        return $this->isAbstract;
    }


    /**
     * @param array<MethodBuilder|ReflectionMethod> $methods
     */
    public function methods(array $methods): static
    {
        // TODO: Transfer to MethodBuilder::parse()
        $this->methods = array_map(fn (MethodBuilder|ReflectionMethod $method) => match (true) {
            $method instanceof ReflectionMethod => MethodBuilder::fromReflection($method),
            default => $method,
        }, $methods);
        
        return $this;
    }

    /**
     * @return array<MethodBuilder>
     */
    public function getMethods(): array
    {
        return $this->methods;
    }



    public function __toString(): string
    {
        // TODO: Same as function body, need to add new abstraction! 
        $tab = 4;
        $space = str_repeat(' ', $tab);

        $methods = implode("\n\n", $this->methods);

        // TODO: Need to solve problem with nesting bodies of things!
        $methods = implode("\n", array_map(fn ($line) => "{$space}{$line}", explode("\n", $methods)));

        $final = $this->isFinal ? 'final' : '';

        return trim("{$final} class {$this->name}\n{\n{$methods}\n}", ' ');
    }
}
