<?php

declare (strict_types=1);
namespace _PhpScoper0a2ac50786fa\Rector\Legacy\ValueObject;

final class PropertyAndClassMethodName
{
    /**
     * @var string
     */
    private $propertyName;
    /**
     * @var string
     */
    private $classMethodName;
    public function __construct(string $propertyName, string $classMethodName)
    {
        $this->propertyName = $propertyName;
        $this->classMethodName = $classMethodName;
    }
    public function getPropertyName() : string
    {
        return $this->propertyName;
    }
    public function getClassMethodName() : string
    {
        return $this->classMethodName;
    }
}
