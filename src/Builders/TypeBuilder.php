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
        if (count($this->type) === 1 && is_array($single = $this->type[0]) && count($this->type[0]) === 1) {
            return implode('&', $this->type[0]);
        }
        
        $ands = array_map(function (string|array $type) {
            $and = match (true) {
                is_array($type) => implode('&', $type),
                default         => $type 
            };

            return count($type) === 1 ? $and : "({$and})";
        }, $this->type);

        return implode('|', $ands);
    }
}
