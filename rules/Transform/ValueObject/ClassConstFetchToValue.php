<?php

declare(strict_types=1);

namespace Rector\Transform\ValueObject;

use PHPStan\Type\ObjectType;

final class ClassConstFetchToValue
{
    /**
     * @var string
     */
    private $class;

    /**
     * @var string
     */
    private $constant;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     */
    public function __construct(string $class, string $constant, $value)
    {
        $this->class = $class;
        $this->constant = $constant;
        $this->value = $value;
    }

    public function getObjectType(): ObjectType
    {
        return new ObjectType($this->class);
    }

    public function getConstant(): string
    {
        return $this->constant;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}
