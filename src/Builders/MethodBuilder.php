<?php

namespace PHPGen\Builders;

use PHPGen\Contracts\Exportable;

class MethodBuilder implements Exportable
{
    protected ?string $visibility = 'public';
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
        $reflection = new ReflectionFunction($closure);

        $that = new static($name);

        $that->parameters(
            array_map(fn ($parameter) => $parameter->hasType() ? [$parameter->getType(), $parameter->getName()] : [$parameter->getName()], $reflection->getParameters())
        );

        if ($reflection->hasReturnType()) {
            $that->returns($reflection->getReturnType()->__toString());
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



    public function public(): static
    {
        $this->visibility = 'public';
        return $this;
    }

    public function protected(): static
    {
        $this->visibility = 'protected';
        return $this;
    }

    public function private(): static
    {
        $this->visibility = 'private';
        return $this;
    }

    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

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

    protected function prepareParametersForExport(): string
    {
        // TODO: Must be replaced by calling FunctionArgumentBuilder::__toString()
        $result = '';

        if (count($this->parameters) === 0) {
            return $result;
        }

        $args = [];
        foreach ($this->parameters as $arg) {
            $typeProvided = isset($arg[1]);
            $type = $typeProvided ? $arg[0] : null;
            $name = $typeProvided ? $arg[1] : $arg[0];

            $args[] = trim("{$type} \${$name}");
        }

        return implode(', ', $args);
    }



    public function __toString(): string
    {
        $result = trim("{$this->visibility} function");
        $result .= " {$this->name}({$this->prepareParametersForExport()})";
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
