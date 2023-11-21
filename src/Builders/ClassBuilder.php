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

    protected bool $isReadonly = false;

    protected ?string $extends = null;

    protected array $implements = [];

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
        return static::make($reflection->isAnonymous() ? 'Anonymous' : $reflection->getName())
            ->final($reflection->isFinal())
            ->abstract($reflection->isAbstract())
            ->methods($reflection->getMethods());
    }

    /**
     * Create new instance from object
     */
    public static function fromObject(object $anonymous): static
    {
        return static::fromReflection(new ReflectionClass($anonymous));
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
        if ($final && $this->isAbstract) {
            throw new \Exception('PHP class cannot be both final and abstract.');
        }

        $this->isFinal = $final;
        return $this;
    }

    public function isFinal(): bool
    {
        return $this->isFinal;
    }



    public function abstract(bool $abstract = true): static
    {
        if ($abstract && $this->isFinal) {
            throw new \Exception('PHP class cannot be both final and abstract.');
        }

        $this->isAbstract = $abstract;
        return $this;
    }

    public function isAbstract(): bool
    {
        return $this->isAbstract;
    }



    public function readonly(bool $readonly = true): static
    {
        $this->isReadonly = $readonly;
        return $this;
    }

    public function isReadonly(): bool
    {
        return $this->isReadonly;
    }



    public function extends(?string $extends): static
    {
        if ($extends === '') {
            throw new \Exception('extends must contain valid class name.');
        }

        $this->extends = $extends;
        return $this;
    }

    public function getExtends(): ?string
    {
        return $this->extends;
    }



    public function implements(array $implements): static
    {
        // FEAT: Overload to accept not only strings =/
        $this->implements = array_filter($implements, fn (string $implement) => (bool) $implement);
        
        return $this;
    }

    /**
     * @return array<string>
     */
    public function getImplements(): array
    {
        return $this->implements;
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
        $abstract = $this->isAbstract ? 'abstract' : '';
        $readonly = $this->isReadonly ? 'readonly' : '';

        $extends = $this->extends ? "extends {$this->extends}" : '';

        $implements = $this->implements ? "implements " . implode(', ', $this->implements) : '';

        return trim("{$final}{$abstract} {$readonly}") . " " . trim("class {$this->name} {$extends}") . " " . $implements . "\n{\n{$methods}\n}";
    }
}
