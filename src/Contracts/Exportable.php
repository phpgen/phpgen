<?php

namespace PHPGen\Contracts;

use Stringable;

// TODO: Extend Laravel's Arrayable contract
interface Exportable extends Stringable
{
    public function __toString(): string;

    public function toJson(): string;

    public function toArray(): array;
}