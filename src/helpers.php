<?php

namespace PHPGen;

use PHPGen\Builders\ClassBuilder;

/**
 * Create PHP class builder
 * 
 * @param string|\ReflectionClass|object $from
 */
function buildClass(string|object $from): ClassBuilder {
    if ($from instanceof \ReflectionClass) {
        return ClassBuilder::fromReflection($from);
    }
    elseif (is_object($from)) {
        return ClassBuilder::fromObject($from);
    }
    elseif (is_string($from)) {
        return ClassBuilder::make($from);
    }

    $type = gettype($from);

    throw new \Exception("Cannot create ClassBuilder from type {$type}.");
}