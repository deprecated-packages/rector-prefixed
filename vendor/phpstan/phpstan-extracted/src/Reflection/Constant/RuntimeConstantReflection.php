<?php

declare (strict_types=1);
namespace PHPStan\Reflection\Constant;

use PHPStan\Reflection\GlobalConstantReflection;
use PHPStan\TrinaryLogic;
use PHPStan\Type\Type;
class RuntimeConstantReflection implements \PHPStan\Reflection\GlobalConstantReflection
{
    /** @var string */
    private $name;
    /** @var Type */
    private $valueType;
    /** @var string|null */
    private $fileName;
    public function __construct(string $name, \PHPStan\Type\Type $valueType, ?string $fileName)
    {
        $this->name = $name;
        $this->valueType = $valueType;
        $this->fileName = $fileName;
    }
    public function getName() : string
    {
        return $this->name;
    }
    public function getValueType() : \PHPStan\Type\Type
    {
        return $this->valueType;
    }
    public function getFileName() : ?string
    {
        return $this->fileName;
    }
    public function isDeprecated() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
    public function getDeprecatedDescription() : ?string
    {
        return null;
    }
    public function isInternal() : \PHPStan\TrinaryLogic
    {
        return \PHPStan\TrinaryLogic::createNo();
    }
}
