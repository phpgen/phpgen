<?php

namespace PHPGen;

use PHPGen\Builders\ClassBuilder;
use PHPGen\Builders\InterfaceBuilder;
use ReflectionClass;

/**
 * Create PHP class builder
 */
function buildClass(null|string|object $from = null): ClassBuilder
{
    return match (true) {
        $from instanceof ReflectionClass => ClassBuilder::fromReflection($from),
        is_object($from)                 => ClassBuilder::fromObject($from),
        default                          => ClassBuilder::make($from)
    };
}

/**
 * Create PHP interface builder
 */
function buildInterface(null|string|ReflectionClass $from = null): InterfaceBuilder
{
    return match (true) {
        $from instanceof ReflectionClass => InterfaceBuilder::fromReflection($from),
        default                          => InterfaceBuilder::make($from)
    };
}
