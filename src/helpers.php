<?php

namespace PHPGen;

use Closure;
use PHPGen\Builders\ClassBuilder;
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
    return match (true) {
        $from instanceof ReflectionClass => InterfaceBuilder::fromReflection($from),
        default                          => InterfaceBuilder::make($from)
    };
}

function buildClass(null|string|object $from = null): ClassBuilder
{
    return match (true) {
        $from instanceof ReflectionClass => ClassBuilder::fromReflection($from),
        is_object($from)                 => ClassBuilder::fromObject($from),
        default                          => ClassBuilder::make($from)
    };
}

function buildProperty(null|string|object $from = null): PropertyBuilder
{
    return match (true) {
        $from instanceof ReflectionProperty => PropertyBuilder::fromReflection($from),
        default                             => PropertyBuilder::make($from)
    };
}

function buildFunction(null|string|object $from = null): FunctionBuilder
{
    return match (true) {
        $from instanceof ReflectionFunctionAbstract => FunctionBuilder::fromReflection($from),
        $from instanceof Closure                    => FunctionBuilder::fromClosure($from),
        default                                     => FunctionBuilder::make($from)
    };
}

function buildParameter(null|string|object $from = null): FunctionParameterBuilder
{
    return match (true) {
        $from instanceof ReflectionParameter => FunctionParameterBuilder::fromReflection($from),
        default                              => FunctionParameterBuilder::make($from)
    };
}

function buildType(null|string|array|object $from = null): TypeBuilder
{
    $from ??= [];

    return match (true) {
        $from instanceof ReflectionType => TypeBuilder::fromReflection($from),
        is_string($from)                => TypeBuilder::fromString($from),
        default                         => TypeBuilder::make($from),
    };
}

function buildMethod(null|string|object $from = null): MethodBuilder
{
    return match (true) {
        $from instanceof ReflectionFunctionAbstract => MethodBuilder::fromReflection($from),
        $from instanceof FunctionBuilder            => MethodBuilder::fromFunctionBuilder($from),
        $from instanceof Closure                    => MethodBuilder::fromClosure($from),
        default                                     => MethodBuilder::make($from)
    };
}
