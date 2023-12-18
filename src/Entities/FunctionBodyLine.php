<?php

namespace PHPGen\Entities;

use Exception;
use Stringable;

class FunctionBodyLine implements Stringable
{
    protected int $ident = 1;

    protected string $content = '';



    public static function make(): static
    {
        return new static;
    }

    public function ident(int $ident): static
    {
        if ($ident < 0) {
            throw new Exception('Function body line cannot has negative ident.');
        }

        $this->ident = $ident;

        return $this;
    }

    public function content(string $content): static
    {
        $this->content = $content;

        return $this;
    }



    public function __toString(): string
    {
        $ident = str_repeat('    ', $this->ident - 1);

        return "{$ident}{$this->content}";
    }
}
