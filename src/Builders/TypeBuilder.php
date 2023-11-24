<?php

namespace PHPGen\Builders;

use PHPGen\Builders\Concerns\HasName;
use PHPGen\Builders\Concerns\HasVisibility;
use PHPGen\Contracts\BodyMember;
use PHPGen\Enums\Visibility;
use ReflectionProperty;
use Stringable;

class TypeBuilder implements Stringable
{
    protected array $type = [];



    /**
     * @param array<int,string|array<int,string>> $type
     */
    public function __construct(array $type = [])
    {
        $this->type = $type;
    }

    /**
     * @param string|array<int,string|array<int,string>> $type
     */
    public static function make(string|array $type = []): static
    {
        if (is_string($type)) {
            $type = [$type];
        }

        return new static($type);
    }

    // public static function fromString(string $type): static
    // {

    //     return static::make($reflection);
    // }

    // public static function fromReflection(ReflectionType $reflection): static
    // {
    //     return static::fromString($reflection);
    // }



    public function __toString(): string
    {
        $ands = array_map(function (string|array $type) {
            return match (true) {
                is_array($type) => '(' . implode('&', $type) . ')',
                default         => $type 
            };
        }, $this->type);

        return implode('|', $ands);
    }
}
