<?php

namespace PHPGen\Builders;

use PHPGen\Exceptions\ValidationException;
use PHPGen\Parsers\TypeParser;
use PHPGen\Sanitizers\TypeSanitizer;
use PHPGen\Validators\TypeValidator;
use ReflectionType;
use Stringable;

class TypeBuilder implements Stringable
{
    /**
     * @var array<array<string>>
     */
    protected array $type = [];



    /**
     * @param array<string|array<string>> $type
     */
    public function __construct(array $type = [])
    {
        $this->type = TypeValidator::valid(TypeSanitizer::sanitize($type));
    }

    /**
     * @param array<string|array<string>> $type
     */
    public static function make(array $type = []): static
    {
        return new static($type);
    }

    public static function fromString(string $type): static
    {
        if ($type === '') {
            throw new ValidationException('Type cannot be empty string.');
        }

        return new static(TypeParser::parse($type));
    }

    public static function fromReflection(ReflectionType $reflection): static
    {
        return static::fromString((string) $reflection);
    }



    public function __toString(): string
    {
        $isSingleOr = count($this->type) === 1;

        $orList = array_map(function (array $andList) use ($isSingleOr): string {
            $or = implode('&', $andList);

            if (count($andList) !== 1 && !$isSingleOr) {
                $or = "({$or})";
            }

            return $or;
        }, $this->type);

        return implode('|', $orList);
    }
}
