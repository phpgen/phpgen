<?php

namespace PHPGen\Builders;

use Closure;
use PHPGen\Builders\Concerns\HasName;
use PHPGen\Builders\Concerns\HasReference;
use PHPGen\Builders\Concerns\HasType;
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

    /**
     * @var array<FunctionParameterBuilder>
     */
    protected array $parameters = [];

    protected ?FunctionBodyBuilder $body = null;



    public function __construct(?string $name = null)
    {
        $this->name($name);
    }

    public static function make(?string $name = null): static
    {
        return new static($name);
    }

    public static function fromClosure(Closure $closure): static
    {
        return static::fromReflection(new ReflectionFunction($closure))->name(null);
    }

    public static function fromReflection(ReflectionFunctionAbstract $reflection): static
    {
        $name = $reflection->isClosure() ? null : $reflection->getName();

        return static::make($name)
            ->parameters($reflection->getParameters())
            ->return($reflection->getReturnType())
            ->returnsByReference($reflection->returnsReference())
            ->body(FunctionBodyBuilder::fromReflection($reflection));
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
        array_walk($parameters, $this->addParameter(...));

        return $this;
    }

    public function addParameter(string|object $parameter): static
    {
        if (!$parameter instanceof FunctionParameterBuilder) {
            $parameter = buildParameter($parameter);
        }

        $this->parameters[] = $parameter;

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



    public function body(null|string|array|FunctionBodyBuilder $body): static
    {
        $this->body = $body instanceof FunctionBodyBuilder ? $body : buildFunctionBody($body);

        return $this;
    }

    public function getBody(): FunctionBodyBuilder
    {
        return $this->body ??= FunctionBodyBuilder::make();
    }



    public function __toString(): string
    {
        $reference  = $this->returnsReference() ? '&' : '';
        $name       = $this->getName();
        $parameters = implode(', ', $this->getParameters());
        $return     = ($returnType = $this->getReturnType())->isNotEmpty() ? ": {$returnType}" : '';
        $body       = (string) $this->getBody();

        return "function {$reference}{$name}({$parameters}){$return}\n{$body}";
    }
}
