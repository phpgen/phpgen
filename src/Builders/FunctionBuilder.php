<?php

namespace PHPGen\Builders;

use PHPGen\Contracts\Exportable;

use Closure;

class FunctionBuilder implements Exportable
{
    protected string $name;
    protected array $parameters = [];
    protected ?string $return = null;
    protected ?string $body = null;



    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public static function make(string $name): static
    {
        return new static($name);
    }

    public static function fromClosure(string $name, Closure $closure): static
    {
        $reflection = new \ReflectionFunction($closure);

        $that = new static($name);

        $that->parameters(
            array_map(FunctionParameterBuilder::fromReflection(...), $reflection->getParameters())
        );

        if ($reflection->hasReturnType()) {
            $that->return($reflection->getReturnType()->getName());
        }

        // TODO: Find a way to parse closure body.
        // $body = '';
        // $lines = file($reflection->getFileName());
        // for($l = $reflection->getStartLine(); $l < $reflection->getEndLine(); $l++) {
        //     $body .= $lines[$l];
        // }
        // $this->body($body);

        return $that;
    }



    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param array<FunctionParameterBuilder> $parameters
     */
    public function parameters(array $parameters): static
    {
        $this->parameters = $parameters;
        return $this;
    }

    public function return(string $type): static
    {
        $this->return = $type;
        return $this;
    }

    public function body(string $body): static
    {
        $this->body = $body;
        return $this;
    }



    protected function prepareBodyForExport(): string
    {
        // TODO: Must be replaced by calling MethodBodyBuilder::__toString()
        $tab = 4;
        $space = str_repeat(' ', $tab);
        
        if (!$this->body) return "{$space}//";

        $rows = explode("\n", $this->body);
        foreach ($rows as $i => $row) {
            $rows[$i] = "{$space}{$row}";
        }

        return implode("\n", $rows);
    }


    
    public function __toString(): string
    {
        $parameters = implode(', ', $this->parameters);
        $result = "function {$this->name}({$parameters})";
        if ($this->return) {
            $result .= ": {$this->return}";
        }
        $result .= "\n{\n{$this->prepareBodyForExport()}\n}";
        
        return $result;
    }

    public function toArray(): array
    {
        return [];
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }
}
