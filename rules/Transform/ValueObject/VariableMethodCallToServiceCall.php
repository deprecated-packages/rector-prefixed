<?php

declare(strict_types=1);

namespace Rector\Transform\ValueObject;

use PHPStan\Type\ObjectType;

final class VariableMethodCallToServiceCall
{
    /**
     * @var string
     */
    private $variableType;

    /**
     * @var string
     */
    private $methodName;

    /**
     * @var mixed
     */
    private $argumentValue;

    /**
     * @var string
     */
    private $serviceType;

    /**
     * @var string
     */
    private $serviceMethodName;

    /**
     * @param mixed $argumentValue
     */
    public function __construct(
        string $variableType,
        string $methodName,
        $argumentValue,
        string $serviceType,
        string $serviceMethodName
    ) {
        $this->variableType = $variableType;
        $this->methodName = $methodName;
        $this->argumentValue = $argumentValue;
        $this->serviceType = $serviceType;
        $this->serviceMethodName = $serviceMethodName;
    }

    public function getVariableObjectType(): ObjectType
    {
        return new ObjectType($this->variableType);
    }

    public function getMethodName(): string
    {
        return $this->methodName;
    }

    /**
     * @return mixed
     */
    public function getArgumentValue()
    {
        return $this->argumentValue;
    }

    public function getServiceType(): string
    {
        return $this->serviceType;
    }

    public function getServiceMethodName(): string
    {
        return $this->serviceMethodName;
    }
}
