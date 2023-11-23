<?php

namespace PHPGen;

use PHPGen\Builders\ClassBuilder;

/**
 * Create PHP class builder
 * 
 * @param null|string|\ReflectionClass|object $from
 */
function buildClass(null|string|object $from = null): ClassBuilder {
    if ($from instanceof \ReflectionClass) {
        return ClassBuilder::fromReflection($from);
    }
    elseif (is_object($from)) {
        return ClassBuilder::fromObject($from);
    }
    elseif (is_string($from)) {
        return ClassBuilder::make($from);
    }

    return ClassBuilder::make();
}