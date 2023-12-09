<?php

namespace PHPGen\Builders;

use Closure;
use PHPGen\Contracts\BodyMember;
use ReflectionClass;
use ReflectionFunctionAbstract;
use ReflectionMethod;
use ReflectionProperty;
use Stringable;

use function PHPGen\buildMethod;

/**
 * Body for classes, interfaces, enums.
 */
class BodyBuilder implements Stringable
{
    protected array $members = [];



    public static function make(): static
    {
        return new static();
    }

    public static function fromReflection(ReflectionClass $reflection): static
    {
        // TODO: Constants
        // TODO: Traits
        $name = $reflection->isAnonymous() ? null : $reflection->getName();

        return static::make($name)
            ->properties($reflection->getProperties())
            ->methods($reflection->getMethods());
    }



    /**
     * @param array<int,string|MethodBuilder|FunctionBuilder|Closure|ReflectionFunctionAbstract> $methods
     */
    public function methods(array $methods): static
    {
        return $this->flushMethods()->addMethods($methods);
    }

    /**
     * @param array<int,string|MethodBuilder|FunctionBuilder|Closure|ReflectionFunctionAbstract> $methods
     */
    public function addMethods(array $methods): static
    {
        array_walk($methods, $this->addMethod(...));

        return $this;
    }

    public function addMethod(string|MethodBuilder|FunctionBuilder|Closure|ReflectionFunctionAbstract $method): static
    {
        if (!$method instanceof MethodBuilder) {
            $method = buildMethod($method);
        }

        $this->members[] = $method;

        return $this;
    }

    /**
     * @return array<MethodBuilder>
     */
    public function getMethods(?callable $callback = null): array
    {
        $methods = array_filter($this->members, fn (BodyMember $member) => $member instanceof MethodBuilder);

        return $callback === null ? $methods : array_filter($methods, $callback);
    }

    public function flushMethods(): static
    {
        foreach ($this->members as $index => $member) {
            if ($member instanceof MethodBuilder) {
                unset($this->members[$index]);
            }
        }

        return $this;
    }



    /**
     * @param array<int,string|PropertyBuilder|ReflectionProperty> $methods
     */
    public function properties(array $properties): static
    {
        return $this->flushProperties()->addProperties($properties);
    }

    /**
     * @param string|array<int,string|PropertyBuilder|ReflectionProperty> $methods
     */
    public function addProperties(string|array $properties): static
    {
        if (is_string($properties)) {
            $properties = [$properties];
        }

        array_walk($properties, function (string|PropertyBuilder|ReflectionProperty $property) {
            $this->members[] = match (true) {
                $property instanceof PropertyBuilder    => $property,
                $property instanceof ReflectionProperty => PropertyBuilder::fromReflection($property),
                default                                 => PropertyBuilder::make($property)
            };
        });

        return $this;
    }

    /**
     * @return array<PropertyBuilder>
     */
    public function getProperties(?callable $callback = null): array
    {
        $properties = array_filter($this->members, fn (BodyMember $member) => $member instanceof PropertyBuilder);

        return $callback === null ? $properties : array_filter($properties, $callback);
    }

    public function flushProperties(): static
    {
        foreach ($this->members as $index => $member) {
            if ($member instanceof BodyMember) {
                unset($this->members[$index]);
            }
        }

        return $this;
    }



    public function __toString(): string
    {
        // TODO: Need printer
        // dd($this->members);
        $indentation   = '    ';
        $membersString = implode("\n\n", $this->members);
        $rows          = explode("\n", $membersString);
        $rows          = array_map(fn (string $s) => "{$indentation}{$s}", $rows);

        return "\n{\n" . implode("\n", $rows) . "\n}\n";
        // return "\n{\n\n}\n";
    }
}
