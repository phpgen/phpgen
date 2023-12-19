<?php

namespace PHPGen;

use Closure;
use PHPGen\Builders\ClassBuilder;
use PHPGen\Builders\FunctionBodyBuilder;
use PHPGen\Builders\FunctionBuilder;
use PHPGen\Builders\FunctionParameterBuilder;
use PHPGen\Builders\InterfaceBuilder;
use PHPGen\Builders\MethodBuilder;
use PHPGen\Builders\PropertyBuilder;
use PHPGen\Builders\TypeBuilder;
use ReflectionClass;
use ReflectionFunctionAbstract;
use ReflectionParameter;
use ReflectionProperty;
use ReflectionType;

function buildInterface(null|string|ReflectionClass $from = null): InterfaceBuilder
{
    if ($from === null) {
        return InterfaceBuilder::make();
    }

    return match (true) {
        $from instanceof ReflectionClass => InterfaceBuilder::fromReflection($from),
        default                          => InterfaceBuilder::make($from)
    };
}

function buildClass(null|string|ReflectionClass $from = null): ClassBuilder
{
    if ($from === null) {
        return ClassBuilder::make();
    }

    return match (true) {
        $from instanceof ReflectionClass => ClassBuilder::fromReflection($from),
        str_contains($from, '\\')        => ClassBuilder::fromNamespace($from),
        default                          => ClassBuilder::make($from)
    };
}

function buildProperty(null|string|ReflectionProperty $from = null): PropertyBuilder
{
    if ($from === null) {
        return PropertyBuilder::make();
    }

    return match (true) {
        $from instanceof ReflectionProperty => PropertyBuilder::fromReflection($from),
        default                             => PropertyBuilder::make($from)
    };
}

function buildMethod(null|string|ReflectionFunctionAbstract|FunctionBuilder|Closure $from = null): MethodBuilder
{
    if ($from === null) {
        return MethodBuilder::make();
    }

    return match (true) {
        $from instanceof ReflectionFunctionAbstract => MethodBuilder::fromReflection($from),
        $from instanceof FunctionBuilder            => MethodBuilder::fromFunctionBuilder($from),
        $from instanceof Closure                    => MethodBuilder::fromClosure($from),
        default                                     => MethodBuilder::make($from)
    };
}

function buildFunction(null|string|ReflectionFunctionAbstract|Closure $from = null): FunctionBuilder
{
    if ($from === null) {
        return FunctionBuilder::make();
    }

    return match (true) {
        $from instanceof ReflectionFunctionAbstract => FunctionBuilder::fromReflection($from),
        $from instanceof Closure                    => FunctionBuilder::fromClosure($from),
        default                                     => FunctionBuilder::make($from)
    };
}

function buildParameter(null|string|ReflectionParameter $from = null): FunctionParameterBuilder
{
    if ($from === null) {
        return FunctionParameterBuilder::make();
    }

    return match (true) {
        $from instanceof ReflectionParameter => FunctionParameterBuilder::fromReflection($from),
        default                              => FunctionParameterBuilder::make($from)
    };
}

function buildType(null|string|array|ReflectionType $from = null): TypeBuilder
{
    if ($from === null) {
        return TypeBuilder::make();
    }

    return match (true) {
        $from instanceof ReflectionType => TypeBuilder::fromReflection($from),
        is_string($from)                => TypeBuilder::fromString($from),
        default                         => TypeBuilder::make($from),
    };
}

function buildFunctionBody(null|string|array|ReflectionFunctionAbstract $from = null): FunctionBodyBuilder
{
    if ($from === null) {
        return FunctionBodyBuilder::make();
    }

    if (is_string($from)) {
        $from = explode("\n", $from);
    }

    return match (true) {
        $from instanceof ReflectionFunctionAbstract => FunctionBodyBuilder::fromReflection($from),
        default                                     => FunctionBodyBuilder::make($from)
    };
}
