<?php

namespace PHPGen\Enums;

use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionProperty;

enum Visibility: string
{
    case Public    = 'public';
    case Protected = 'protected';
    case Private   = 'private';



    public static function tryFromReflection(ReflectionFunctionAbstract|ReflectionProperty $reflection): ?static
    {
        if ($reflection instanceof ReflectionFunction) {
            return null;
        }

        return match (true) {
            $reflection->isPublic()    => self::Public,
            $reflection->isProtected() => self::Protected,
            $reflection->isPrivate()   => self::Private,
            default                    => null
        };
    }
}
