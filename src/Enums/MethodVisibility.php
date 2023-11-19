<?php

namespace PHPGen\Enums;

use ReflectionFunctionAbstract;
use ReflectionMethod;

enum MethodVisibility: string
{
    case Public = 'public';
    case Protected = 'protected';
    case Private = 'private';



    public static function tryFromReflection(ReflectionFunctionAbstract $reflection): ?static
    {
        if (!$reflection instanceof ReflectionMethod) {
            return null;
        }

        return match (true) {
            $reflection->isPublic()    => static::Public,
            $reflection->isProtected() => static::Protected,
            $reflection->isPrivate()   => static::Private,
            default => null
        };
    }
}
