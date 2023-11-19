<?php

namespace PHPGen\Builders;

use Stringable;

class FunctionBodyBuilder implements Stringable
{
    protected array $lines = []; 



    /**
     * @param array<string> $lines
     */
    public function __construct(array $lines = [])
    {
        $this->lines = array_filter(array_map(trim(...), $lines));
    }
    
    /**
     * Create new instance
     * 
     * @param array<string> $lines
     */
    public static function make(array $lines = []): static
    {
        return new static($lines);
    }

    /**
     * Create new instance from string
     */
    public static function fromString(string $body): static
    {
        return new static(explode("\n", $body));
    }



    public function __toString(): string
    {
        $tab = 4;
        $space = str_repeat(' ', $tab);
        
        if (count($this->lines) === 0) return "{\n\n}";

        return "{\n" . implode("\n", array_map(fn ($line) => "{$space}{$line}", $this->lines)) . "\n}";
    }
}
