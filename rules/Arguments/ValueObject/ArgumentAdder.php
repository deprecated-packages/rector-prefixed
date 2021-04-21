<?php

declare (strict_types=1);
namespace Rector\Arguments\ValueObject;

use PHPStan\Type\ObjectType;
final class ArgumentAdder
{
    /**
     * @var string
     */
    private $class;
    /**
     * @var string
     */
    private $method;
    /**
     * @var int
     */
    private $position;
    /**
     * @var string|null
     */
    private $argumentName;
    /**
     * @var mixed|null
     */
    private $argumentDefaultValue;
    /**
     * @var string|null
     */
    private $argumentType;
    /**
     * @var string|null
     */
    private $scope;
    /**
     * @param mixed|null $argumentDefaultValue
     * @param string|null $argumentName
     * @param string|null $argumentType
     * @param string|null $scope
     */
    public function __construct(string $class, string $method, int $position, $argumentName = null, $argumentDefaultValue = null, $argumentType = null, $scope = null)
    {
        $this->class = $class;
        $this->method = $method;
        $this->position = $position;
        $this->argumentName = $argumentName;
        $this->argumentDefaultValue = $argumentDefaultValue;
        $this->argumentType = $argumentType;
        $this->scope = $scope;
    }
    public function getObjectType() : \PHPStan\Type\ObjectType
    {
        return new \PHPStan\Type\ObjectType($this->class);
    }
    public function getMethod() : string
    {
        return $this->method;
    }
    public function getPosition() : int
    {
        return $this->position;
    }
    /**
     * @return string|null
     */
    public function getArgumentName()
    {
        return $this->argumentName;
    }
    /**
     * @return mixed|null
     */
    public function getArgumentDefaultValue()
    {
        return $this->argumentDefaultValue;
    }
    /**
     * @return string|null
     */
    public function getArgumentType()
    {
        return $this->argumentType;
    }
    /**
     * @return string|null
     */
    public function getScope()
    {
        return $this->scope;
    }
}
