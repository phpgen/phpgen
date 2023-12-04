<?php

namespace PHPGen\Builders;

use PHPGen\Builders\Concerns\HasBody;
use PHPGen\Builders\Concerns\HasExtends;
use PHPGen\Builders\Concerns\HasImplements;
use PHPGen\Builders\Concerns\HasName;
use ReflectionClass;
use Stringable;

class ClassBuilder implements Stringable
{
    use HasBody;
    use HasExtends;
    use HasImplements;
    use HasName;


    protected bool $isFinal    = false;
    protected bool $isAbstract = false;
    protected bool $isReadonly = false;

    protected array $methods = [];



    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    public static function make(?string $name = null): static
    {
        return new static($name);
    }

    public static function fromReflection(ReflectionClass $reflection): static
    {
        $name = $reflection->isAnonymous() ? null : $reflection->getName();

        return static::make($name)
            ->final($reflection->isFinal())
            ->abstract($reflection->isAbstract())
            ->body(BodyBuilder::fromReflection($reflection));
    }

    public static function fromObject(object $anonymous): static
    {
        return static::fromReflection(new ReflectionClass($anonymous));
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



    public function __toString(): string
    {
        // TODO: Same as function body, need to add new abstraction!
        $tab   = 4;
        $space = str_repeat(' ', $tab);

        $final    = $this->isFinal ? 'final' : '';
        $abstract = $this->isAbstract ? 'abstract' : '';
        $readonly = $this->isReadonly ? 'readonly' : '';

        $extends = $this->extends ? "extends {$this->extends}" : '';

        $implements = $this->implements ? 'implements ' . implode(', ', $this->implements) : '';

        return trim("{$final}{$abstract} {$readonly}") . ' ' . trim("class {$this->getName()} {$extends}") . ' ' . $implements . $this->body;
    }
}
