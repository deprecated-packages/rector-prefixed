<?php

declare (strict_types=1);
namespace Rector\Transform\ValueObject;

use PHPStan\Type\ObjectType;
final class FuncCallToMethodCall
{
    /**
     * @var string
     */
    private $oldFuncName;
    /**
     * @var string
     */
    private $newClassName;
    /**
     * @var string
     */
    private $newMethodName;
    public function __construct(string $oldFuncName, string $newClassName, string $newMethodName)
    {
        $this->oldFuncName = $oldFuncName;
        $this->newClassName = $newClassName;
        $this->newMethodName = $newMethodName;
    }
    public function getOldFuncName() : string
    {
        return $this->oldFuncName;
    }
    public function getNewObjectType() : \PHPStan\Type\ObjectType
    {
        return new \PHPStan\Type\ObjectType($this->newClassName);
    }
    public function getNewMethodName() : string
    {
        return $this->newMethodName;
    }
}
