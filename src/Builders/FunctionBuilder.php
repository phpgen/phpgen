<?php

namespace PHPGen\Builders;

use Closure;
use PHPGen\Builders\Concerns\HasName;
use PHPGen\Builders\Concerns\HasReference;
use PHPGen\Builders\Concerns\HasType;
use PHPGen\Builders\FunctionBodyBuilder as Body;
use ReflectionFunction;
use ReflectionFunctionAbstract;
use Stringable;

use function PHPGen\buildFunctionBody;
use function PHPGen\buildParameter;

class FunctionBuilder implements Stringable
{
    use HasName;
    use HasReference {
        byReference as private _byReference;
        byRef as private _byRef;
        isReference as private _isReference;
        isRef as private _isRef;
    }
    use HasType {
        type as private _type;
        getType as private _getType;
    }

    protected array $parameters = [];
    protected ?Body $body       = null;



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
        return static::make($reflection->getName())
            ->parameters($reflection->getParameters())
            ->return($reflection->getReturnType())
            ->returnsByReference($reflection->returnsReference())
            ->body(Body::fromReflection($reflection));
    }

    public static function fromClosure(Closure $closure): static
    {
        return static::fromReflection(new ReflectionFunction($closure))->name(null);
    }



    /**
     * @param array<string|object> $parameters
     */
    public function parameters(array $parameters): static
    {
        return $this->flushParameters()->addParameters($parameters);
    }

    /**
     * @param array<string|object> $parameters
     */
    public function addParameters(array $parameters): static
    {
        array_walk($parameters, function (string|object $parameter) {
            $this->parameters[] = $parameter instanceof FunctionParameterBuilder
                ? $parameter
                : buildParameter($parameter);
        });

        return $this;
    }

    public function addParameter(string|object $parameter): static
    {
        $this->parameters[] = $parameter instanceof FunctionParameterBuilder
            ? $parameter
            : buildParameter($parameter);

        return $this;
    }

    /**
     * @return array<int,FunctionParameterBuilder>
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function flushParameters(): static
    {
        $this->parameters = [];

        return $this;
    }



    public function return(null|string|array|object $from = null): static
    {
        return $this->_type($from);
    }

    public function getReturnType(): TypeBuilder
    {
        return $this->_getType();
    }



    public function returnsByReference(bool $byReference = true): static
    {
        return $this->_byReference($byReference);
    }

    public function returnsByRef(bool $byRef = true): static
    {
        return $this->_byRef($byRef);
    }

    public function returnsReference(): bool
    {
        return $this->_isReference();
    }

    public function returnsRef(): bool
    {
        return $this->_isRef();
    }



    public function returnReferenced(null|string|array|object $from = null): static
    {
        return $this->returnsByReference(true)->return($from);
    }



    public function body(null|string|Body $body): static
    {
        $this->body = $body instanceof Body ? $body : buildFunctionBody($body);

        return $this;
    }

    public function getBody(): Body
    {
        return $this->body ??= Body::make();
    }



    public function __toString(): string
    {
        $parameters = implode(', ', $this->parameters);
        $reference  = $this->returnsReference() ? '&' : '';
        $result     = "function {$reference}{$this->getName()}({$parameters})";

        if ($this->getReturnType()->isNotEmpty()) {
            $result .= ": {$this->getReturnType()}";
        }

        $result .= "\n" . $this->getBody();

        return $result;
    }
}
