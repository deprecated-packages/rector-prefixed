<?php

declare (strict_types=1);
namespace _PhpScoperb75b35f52b74\Rector\Legacy\ValueObject;

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
