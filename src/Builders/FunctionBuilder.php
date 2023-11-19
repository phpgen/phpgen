<?php

namespace PHPGen\Builders;

use Closure;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionParameter;
use Stringable;

class FunctionBuilder implements Stringable
{
    protected string $name;
    protected array $parameters = [];
    protected ?string $return = null;
    protected ?FunctionBodyBuilder $body = null;



    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Create new instance
     */
    public static function make(string $name): static
    {
        return new static($name);
    }

    /**
     * Create new instance from reflection.
     */
    public static function fromReflection(ReflectionFunctionAbstract $reflection): static
    {
        // TODO: Parse body
        return static::make($reflection->getName())
            ->parameters($reflection->getParameters())
            ->return($reflection->getReturnType());

        // $body = '';
        // $lines = file($reflection->getFileName());
        // for($l = $reflection->getStartLine() - 1; $l < $reflection->getEndLine(); $l++) {
        //     $body .= $lines[$l];
        // }
    }

    /**
     * Create new instance from Closure.
     */
    public static function fromClosure(string $name, Closure $closure): static
    {
        $reflection = new ReflectionFunction($closure);

        return static::fromReflection($reflection)->name($name);
    }



    /**
     * Set name
     */
    public function name(string $name): static
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     */
    public function getName(): string
    {
        return $this->name;
    }


    /**
     * Set parameters
     * 
     * @param array<FunctionParameterBuilder|ReflectionParameter> $parameters
     */
    public function parameters(array $parameters): static
    {
        // TODO: Transfer to FunctionParameterBuilder::parse()
        $this->parameters = array_map(fn (FunctionParameterBuilder|ReflectionParameter $parameter) => match (true) {
            $parameter instanceof ReflectionParameter => FunctionParameterBuilder::fromReflection($parameter),
            default => $parameter,
        }, $parameters);
        
        return $this;
    }

    /**
     * Get parameters
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }


    /**
     * Set return type
     */
    public function return(?string $type): static
    {
        $this->return = $type;
        return $this;
    }

    /**
     * Get return type
     */
    public function getReturn(): ?string
    {
        return $this->return;
    }


    /**
     * Set body
     * 
     * @param null|string|array<string>|FunctionBodyBuilder $body
     */
    public function body(null|string|array|FunctionBodyBuilder $body): static
    {
        if ($body === null) {
            if ($this->body === null) {
                return $this;
            }
            else {
                $this->body = null;
                return $this;
            }
        }

        if ($body instanceof FunctionBodyBuilder) {
            $this->body = $body;
        }
        else if (is_array($body)) {
            $this->body = FunctionBodyBuilder::make($body);
        }
        else {
            $this->body = FunctionBodyBuilder::fromString($body);
        }

        return $this;
    }

    /**
     * Get body
     */
    public function getBody(): ?FunctionBodyBuilder
    {
        return $this->body;
    }



    public function __toString(): string
    {
        $parameters = implode(', ', $this->parameters);
        $result = "function {$this->name}({$parameters})";

        if ($this->return) {
            $result .= ": {$this->return}";
        }

        $result .= "\n" . ($this->body ?? FunctionBodyBuilder::make());
        
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
