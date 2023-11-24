<?php

namespace PHPGen\Builders;

use Closure;
use PHPGen\Builders\Concerns\HasName;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use ReflectionParameter;
use Stringable;

class FunctionBuilder implements Stringable
{
    use HasName;
    // TODO: use HasType alias type to returnType???;

    protected array $parameters          = [];
    protected ?string $return            = null;
    protected ?FunctionBodyBuilder $body = null;



    public function __construct(?string $name = null)
    {
        $this->name = $name;
    }

    public static function make(?string $name = null): static
    {
        return new static($name);
    }

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

    public static function fromClosure(Closure $closure): static
    {
        $reflection = new ReflectionFunction($closure);

        return static::fromReflection($reflection)->name(null);
    }



    /**
     * @param array<FunctionParameterBuilder|ReflectionParameter> $parameters
     */
    public function parameters(array $parameters): static
    {
        // TODO: Transfer to FunctionParameterBuilder::parse()
        $this->parameters = array_map(fn (FunctionParameterBuilder|ReflectionParameter $parameter) => match (true) {
            $parameter instanceof ReflectionParameter => FunctionParameterBuilder::fromReflection($parameter),
            default                                   => $parameter,
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
            } else {
                $this->body = null;

                return $this;
            }
        }

        if ($body instanceof FunctionBodyBuilder) {
            $this->body = $body;
        } elseif (is_array($body)) {
            $this->body = FunctionBodyBuilder::make($body);
        } else {
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
        $result     = "function {$this->getName()}({$parameters})";

        if ($this->return) {
            $result .= ": {$this->return}";
        }

        $result .= "\n" . ($this->body ?? FunctionBodyBuilder::make());

        return $result;
    }
}
